<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;

class UserController extends Controller
{
    public function users(){
        $users = customer::all();
        return view("admin.all_users",compact("users"));
    }
    public function filter(Request $request)
    {
        // dd($request);
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $start = $request->start;
        $end = $request->end;
        $users = customer::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.all_users', compact('users', 'start', 'end'));
    }
    public function show()
    {
        $users = customer::all();
        return view('admin.all_users', compact('users'));
    }
}
