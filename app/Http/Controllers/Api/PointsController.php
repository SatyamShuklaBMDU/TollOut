<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderHistory;
use App\Models\Points;
use App\Models\ProductsForRedeem;
use Illuminate\Http\Request;

class PointsController extends Controller
{
        public function orderGift(Request $request)
{
        try{
        $user = $request->user();
        $request->validate([
            'product_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|string',
            'phone_no' => 'required|string',
            'allternate_no' => 'nullable|string',
            'address' => 'required|string',
            'pincode' => 'required|string',
            ]);
            // check product coin
            $product=ProductsForRedeem::where('id',$request->product_id)->first();

            //get user potins
            $user_points=Points::where('user_id',$user->id)->sum('points');
        $redeem_coin = Points::where('user_id',$user->id)->sum('redeem_points');
        $total_coin = $user_points - $redeem_coin;


            if($total_coin >=$product->price){
            //compare product or user  coin
               $order= OrderHistory::create([
                    'customer_id' => $user->id,
                    'product_id' => $request->product_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_no' => $request->phone_no,
                    'allternate_no' => $request->allternate_no,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                    'status' => 'pending',
                ]);

                Points::create([
                    'user_id' => $user->id,
                    'redeem_points' =>$product->price,
                    'order_id'=> $order->id,
                ]);

               
                return response()->json([
                    'status' => true,
                    'message' => 'Order placed successfully',
                    ],200);

            }else{
                return response()->json(['message'=>'You have not enough coins to redeem this product'],403);
            }
        }
        catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()],500);
        }
}




public function showCoins(){
    try{
        $user = auth()->user();
        //sum of column
        $total_coin = Points::where('user_id',$user->id)->sum('points');
        // sum and subsrate redeem points
        $redeem_coin = Points::where('user_id',$user->id)->sum('redeem_points');
        $redeem_coin = $total_coin - $redeem_coin;
        return response()->json([
            'status' => true,
            'message' => 'Coins fetched successfully',
            'data' => [
                'total_coin' => $total_coin,
                'available_coin' => $redeem_coin,
                'referral_code'=> $user->referral_code,
                ]
            ]);
            }
            catch(\Exception $e){
                return response()->json(['message'=>$e->getMessage()],500);
                }

            }



}
