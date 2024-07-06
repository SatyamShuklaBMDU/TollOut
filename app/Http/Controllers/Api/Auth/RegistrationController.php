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
    public function registration(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:customers,email',
                'phone' => 'required|numeric|digits:10|unique:customers,phone',
                'password' => 'required|min:8|max:12|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'failed to register', 'errors' => $validator->errors()], 400);
            } else {
                    do {
                        $cust_id = 'CIN' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                        $customer_id = customer::where('customer_id', $cust_id)->first();
                    } while ($customer_id);

                // $count = customer::count('id');
                // $customer_id = 'CIN' . sprintf('%05d', intval($count) + 1);

                $customer = customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => hash::make($request->password),
                    'customer_id' => $cust_id,
                ]);
                return response()->json(['status' => true, 'message' => 'Register Successfully', 'data' => $customer], 200);
            }


        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:8|max:12|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'failed to login', 'errors' => $validator->errors()], 400);
            }
            $check = customer::where('email', $request->email)->first();
            // dd($check);
            if (!$check) {
                return response()->json(['status' => false, 'message' => 'Email ID not found'], 401);
            }
            if ($check->status == true) {
                if (Auth::guard('customers')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    $customer = Auth::guard('customers')->user();
                    $token = $customer->createToken('customertoken')->plainTextToken;
                    return response()->json(['status' => true, 'message' => 'Login Successfully', 'token' => $token, 'data' => $customer], 200);

                } else {
                    return response()->json(['status' => false, 'message' => 'Email ID or Password not Matched'], 401);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Your Account is Inactive'], 401);
            }
            
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->tokens()->delete();
            return response()->json(['status' => true, 'message' => 'Logout Successful'], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'User not Authenticated'], 401);
        }
    }
    public function update(Request $request)
    {
        try {
            $login = Auth::user();
            // dd($login);
            $customer = customer::findOrFail($login->id);

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'gender' => 'nullable|in:Mr.,Miss,Rather not to say',
                'phone' => 'nullable|string',
                'email' => 'email|unique:customers,email,' . $customer->id,
                'dob' => 'nullable|string',
                'profile' => 'nullable|image|max:2048',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            
            if ($request->has('dob') && $request->filled('dob')) {
                try {
                    // Convert string dob to Y-m-d format
                    $dob = Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d');
                } catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Invalid date format. Please use d-m-Y format.'], 400);
                }
            }
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('profile_pics'), $fileName);
                $profile = 'profile_pics/' . $fileName;
            }

            $data = [
                'name' => $request->name ? $request->name : $customer->name,
                'gender' => $request->gender ? $request->gender : $customer->gender,
                'phone' => $request->phone ? $request->phone : $customer->phone,
                'email' => $request->email ? $request->email : $customer->email,
                'dob' => $request->has('dob') && $request->filled('dob') ? $dob : $customer->dob,
                'profile' => $request->hasFile('profile') ? $profile : $customer->profile,
            ];
            $customer->update($data);
            $responseCustomer = $customer->toArray();
            $responseCustomer['dob'] = $customer->dob ? Carbon::createFromFormat('Y-m-d', $customer->dob)->format('d-m-Y') : null;
            $responseCustomer['profile'] = 'https://bmdublog.com/TollOut/public/' . $customer->profile;
            return response()->json(['status' => true, 'message' => 'Customer Details Updated Successfully', 'data' => $responseCustomer]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }

    }
    public function reset(Request $request)
    {
        try {
            $login = Auth::user();
            // dd($login);
            $customer = customer::findOrFail($login->id);
            $validator = Validator::make($request->all(), [
                'new_password' => 'required|min:8|max:12|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $data = [
                'password' => $request->password ? $request->password : hash::make($request->new_password),
            ];
            $customer->update($data);
            return response()->json(['status' => true, 'message' => 'Password Updated Successfully', 'data' => $customer], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function profileinfo(Request $request)
    {
        try {
            $login = Auth::user();
            // dd($login);
            $customer = customer::findOrFail($login->id);
            if ($customer) {
                return response()->json(['status' => true, 'data' => $customer], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
