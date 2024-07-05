<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function logout(){
        Auth::logout();
        return redirect("/");
    }
    public function dashboard(){
        $users = customer::where('status',"1")->count();
        $category = MainCategory::where('status',"0")->count();
        $subcategory = SubCategory::where('status',"0")->count();
        return view("admin.dashboard",compact('users','category','subcategory'));
    }
}
