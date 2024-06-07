<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            
            $count = customer::count('id');
            $customer_id = 'CIN' . sprintf('%05d', intval($count) + 1);
            
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
    public function update(Request $request){
        try{
            $login = Auth::user();
            // dd($login);
            $customer = customer::findOrFail($login->id);
            // dd($customer);

            // if($request-()){
            //     return response()->json(['status'=> true,'data'=> $customer],200);
            // }


            $validator = Validator::make($request->all(),[
                'name' => 'string',
                'Mr_Miss' => 'nullable|in:Mr.,Miss,Rather not to say',
                'phone' => 'nullable|string',
                'email' => 'email|unique:customers,email,'.$customer->id,
                'dob' => 'nullable|date',
                'profile' => 'nullable|image|max:2048',
            ]);
            if($validator->fails()){
                return response()->json(['status'=> false,'message'=> $validator->errors()],400);
            }
            if ($request->has('dob') && $request->filled('dob')) {
                        $dob = Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d');
                    } else {
                        $dob = null; // Set dob to null if not provided
            }              
            if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('profile_pics'), $fileName);
            $profile = 'profile_pics/' . $fileName;
            }

            $data=[
                'name' => $request->name ? $request->name : $customer->name,
                'Mr/Miss' => $request->Mr_Miss,
                'phone' => $request->phone ? $request->phone : $customer->phone,
                'email' => $request->email ? $request->email : $customer->email,
                'dob' => $dob,
                'profile' => $request->hasFile('profile') ? $profile : $customer->profile,
            ];
            $customer->update($data);
            return response()->json(['status'=>true,'message' => 'Customer Details Updated Successfully', 'data' => $customer]);
        }
        catch(\Exception $e){
            return response()->json(['status'=> false,'message'=> $e->getMessage()],500);
        }
       
    }
    public function reset(Request $request){
        try{
        $login = Auth::user();
        // dd($login);
        $customer = customer::findOrFail($login->id);
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:8|max:12|string',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> false,'message'=> $validator->errors()],400);
        }
        $data=[
            'password' => $request->password ? $request->password : hash::make($request->new_password),
        ];
        $customer->update($data);
        return response()->json(['status'=>true,'message' => 'Password Updated Successfully', 'data' => $customer]);
        }
        catch(\Exception $e){
            return response()->json(['status'=> false,'message'=> $e->getMessage()],500);
        }
    }
}
