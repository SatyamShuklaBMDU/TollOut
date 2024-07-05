<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use Illuminate\Http\Request;

class OrderByPointsController extends Controller
{
    public function index(){
        $orders = OrderHistory::with('product')->get();
        return view('orderbypoints.orderbypoints',compact('orders'));

    }
    public function changestatus(Request $request){
        // dd($request->all());
        $user = OrderHistory::find($request->category_id);
        if ($user) {
            $user->status = $request->status;
            $user->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $startDate = $request->start;
        $endDate = $request->end;
        $orders = OrderHistory::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('orderbypoints.orderbypoints', ['orders' => $orders, 'start' => $startDate, 'end' => $endDate]);
    }
}
