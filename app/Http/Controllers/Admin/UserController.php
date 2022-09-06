<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        
    }
    public function index() {
        $users= User::where('role','=','client')->get();
       // dd($users);
        return view('dashboard',['users'=>$users]);
    }

    public function create(){
         return view('users.form-save');
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'client',
            'password' => Hash::make('tahirMbaye21')
        ]);
        return redirect('/dashboard');
       // dd($request);
    }
}
