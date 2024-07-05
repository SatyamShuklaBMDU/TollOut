<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\Points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    //
    public function index()
    {
        //get points by user id unique
        $points =$distinctRecords = DB::table('points')
        ->select('user_id')
        ->distinct()
        ->get();

        //get all points
        return view('points.index',compact('points'));
  }

  public function ShowPointHistory(customer $customer){
    $points = Points::where('user_id',$customer->id)->get();
    return view('points.show',compact('points'));
  }


}
