<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
