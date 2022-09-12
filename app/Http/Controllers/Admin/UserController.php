<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use League\Csv\Reader;
use App\Imports\UserImport;

use Illuminate\Support\Str;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Exports\FilterExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
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
            $users = User::where('role', '=', 'client')
                ->orderBy('id', 'desc')
                ->paginate(5);
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

        //  dd(url()->previous());
        if ($request->archive) {
            $user = User::find($request->archive);
            $user->update([
                'isActivated' => false
            ]);
        }

        if ($request->desarchive) {
            $user = User::find($request->desarchive);
            $user->update([
                'isActivated' => true
            ]);
        }

        return redirect(url()->previous());
    }


    public function storeUpload(Request $request)
    {
        $request->validate([
            'file' => ['required']
        ]);
        /* Laravel excel */
        /*   $file= $request->file('file');
		Excel::import(new UserImport,$file);
	       return redirect('/dashboard'); */
        /* csv league */
        $csv = Reader::createFromPath($request->file('file')->getRealPath());
        $csv->setHeaderOffset(0);
        $user = [];
        foreach ($csv as $record) {
            $user[] = [
                'name' => $record['name'],
                'email' => $record['email'],
                'password' => Hash::make($record['password']),
            ];
            if (count($user) == 10000) {
                User::insert($user);
            }
        }
        /*  User::insert($user);
        $user = [];
        return redirect('/dashboard');*/

        //code php
        /* $file = fopen($request->file('file')->getRealPath(), 'r');
        while ($csv = fgetcsv($file)) {
            User::create([
                'name' => $csv[0],
                'email' => $csv[1],
                'password' => Hash::make($csv[2]),
                'role' => 'client',
                'isActivated' => true
            ]);
        }

        fclose($file);
        return redirect('/dashboard'); */
    }

    public function parseImport(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $file = file($path);
        $data = array_slice($file, 1);
        dd($data);
    }

    public function export()
    {
         return Excel::download(new UsersExport, 'users.csv');

       
    }
}
