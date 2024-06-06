<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function logout(){
        Auth::logout();
        return redirect("/");
    }
    public function dashboard(){
        return view("admin.dashboard");
    }
}
