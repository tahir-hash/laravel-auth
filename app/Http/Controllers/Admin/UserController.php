<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
}
