<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class ManageAdminController extends Controller
{
    public function index(){
        $users = User::where('status',false)->latest()->get();
        return view('manage-admin.manage-admin',compact('users'));
    }
    public function addadmin(){
        return view('manage-admin.add-admin');
    }
    public function addadminstore(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:6',
            'permission' => 'required',
        ], [
            'email.unique' => 'The email address is already in use.',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->permissions = json_encode($request->permission);
        $user->save();
        return redirect()->route('manage-admin')->with('success', 'Admin Added Successfully');
    }
    public function editadmin($id){
        $did = decrypt($id);
        $users = User::findOrFail($did);
        $permission = json_decode($users->permissions,true);
        return view('manage-admin.edit-admin',compact('users','permission'));
    }
    public function editadminstore(Request $request,$id){
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required',
            'permission' => 'required',
        ], [
            'email.unique' => 'The email address is already in use.',
        ]);
        // dd($request->all());
        // $user = new User();
        $user->name = $request->name ? $request->name :$user->name;
        $user->email = $request->email ? $request->email :$user->email;
        $user->role = $request->role ? $request->role :$user->role;
        $user->permissions = json_encode($request->permission ? $request->permission :$user->permissions);
        $user->save();
        return redirect()->route('manage-admin')->with('success', 'Admin Updated Successfully');
    }
    public function delete($id){
        try{
        $user = User::findOrFail($id)->where('status',false)->first();
     
        $user->delete();
        return response()->json(['success' => true]);
        } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);
        $startDate = $request->start;
        $endDate = $request->end;
        $users = User::where('status',false)->whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($users);
        return view('manage-admin.manage-admin', ['users' => $users, 'start' => $startDate, 'end' => $endDate]);
    }

}
