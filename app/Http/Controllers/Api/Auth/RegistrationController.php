<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function registration(Request $request){
        try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|numeric|digits:10|unique:customers,phone',
            'password' => 'required|min:8|max:12|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message'=>'failed to register','errors' => $validator->errors()], 400);
        }else{
            
            $lastRecord = customer::orderBy('id', 'desc')->first();
           
                if(!$lastRecord){
                    $number = 0;
                }else {
                $number = substr($lastRecord->customer_id, 3);
                $customer_id = 'CIN' . sprintf('%05d', intval($number) + 1);
                }
           
            
            $customer = customer::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'password'=> hash::make($request->password),
                'customer_id'=>$customer_id,
            ]);
            return response()->json(['status'=> true,'message'=>'Register Successfully','data'=> $customer],200);
        }
        
    
        } catch(\Exception $e) {
            return response()->json(['status'=> false,'message'=> $e->getMessage()],500);
        }   
    }
    public function login(Request $request){
        try {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:12|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message'=>'failed to login','errors' => $validator->errors()], 400);
        }else{
            
            if(Auth::guard('customers')->attempt(['email' =>$request->email, 'password' =>$request->password ])){
                $customer = Auth::guard('customers')->user();
                $token = $customer->createToken('customertoken')->plainTextToken;
                return response()->json(['status'=> true,'message'=> 'Login Successfully','token'=>$token,'data'=>$customer],200);
            }else{
                return response()->json(['status'=> false,'message'=> 'Email ID or Password not Matched'],500);
            }
        }
    } catch(\Exception $e) {
        return response()->json(['status'=> false,'message'=> $e->getMessage()],500);
    }
    }
    public function logout(Request $request){
        if(Auth::user()){
            $request->user()->tokens()->delete();
            return response()->json(['status'=> true,'message'=> 'Logout Successful'],200);
        }else{
            return response()->json(['status'=> false,'message'=> 'User not Authenticated'],500);
        }
    }
}
