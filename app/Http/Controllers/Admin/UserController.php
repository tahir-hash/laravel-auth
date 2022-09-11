<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use League\Csv\Reader;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {

        // dd($users);
        if (Auth::user()->role == 'admin') {
            $users = User::where('role', '=', 'client')->where('isActivated', '=', true)
                ->orderBy('id', 'desc')
                ->paginate(3);
            return view('dashboard', ['users' => $users]);
        } else {
            return view('dashboardClient');
        }
    }

    public function create()
    {
        return view('users.form-save', [
            'user' => ''
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'client',
            'password' => Hash::make('tahirMbaye21'),
            'isActivated' => true
        ]);
        Alert::success('Success', 'Enregistrement réussi !');
        return redirect('/dashboard');
    }

    public function showData($id)
    {
        $user = User::find($id);

        return view('users.form-save', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        //first method
        /* $user= User::find($request->userId);
        $user->name= $request->name;
        $user->email= $request->email;
        $user->save(); */

        //second method
        $user = User::find($request->userId);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect('/dashboard');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->update);
        $user->update([
            'isActivated' => false
        ]);
        return redirect('/dashboard');
    }


    //public function storeUpload(Request $request)
    //{
    //    $file = $request->file('file');
    //    dd($file);
    //    // Excel::import(new UserImport,$file);
    //    Excel::filter('chunk')->load(database_path($file->getRealPath()))->chunk(250, function ($results) {
    //        foreach ($results as $row) {
    //            $user = User::create([
    //                'name' => $row[0],
    //                'email' => $row[1],
    //                'password' => Hash::make($row[2]),
    //            ]);
    //        }
    //    });
    //    /* $file= fopen($request->file('file')->getRealPath(), 'r');
    //     while($csv=fgetcsv($file)){
    //        User::create([
    //            'name'=>$csv[0],
    //            'email'=>$csv[1],
    //            'password'=>Hash::make($csv[2]),
    //        ]);
    //     }
    //
    //     fclose($file); */
    //    Alert::success('Success', 'Enregistrement réussi !');
    //    return redirect('/dashboard');
    //}

    public function storeUpload(Request $request)
    {
        $csv = Reader::createFromPath($request->file('file')->getRealPath());
        $csv->setHeaderOffset(0);
        $user = [];
        foreach ($csv as $record) {
            $user[]=[
                'name' => $record['name'],
                'email' => $record['email'],
                'password' => Hash::make($record['password']),
            ]; 
        }
        DB::table('users')->insert($user);
      /* $path = $request->file('file')->getRealPath();
        $file= file($path);
        $data = array_slice($file, 1); */
        
    }

    public function parseImport(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $file = file($path);
        $data = array_slice($file, 1);
        dd($data);
    }
}
