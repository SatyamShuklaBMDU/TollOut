<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class wishlistController extends Controller
{
    public function filterdata(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $startDate = $request->start;
        $endDate = $request->end;
        $users = Wishlist::whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($users);
        return view('wishlist.wishlist', ['users' => $users, 'start' => $startDate, 'end' => $endDate]);
    }
    public function index(){
        // $wishlists = Wishlist::all();
        return view('wishlist.wishlist');
    }
}
