<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;

class ManageAdminController extends Controller
{
    public function index(){
        $role = Role::where('role','Super admin')->first();
        $users = User::where('role_id','!=',$role->id)->latest()->get();
        $roles = Role::where('role','!=','Super admin')->get();
        return view('manage-admin.manage-admin',compact('users','roles'));
    }
    public function addadmin(){
        $roles = Role::where('role','!=','Super admin')->get();
        return view('manage-admin.add-admin',compact('roles'));
    }
    public function addadminstore(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|integer',
            'password' => 'required|min:8|string',
        ], [
            'email.unique' => 'The email address is already in use.',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('manage-admin')->with('success', 'Admin Added Successfully');
    }
    public function editadmin($id){
        $did = decrypt($id);
        $users = User::findOrFail($did);
        // $roles = Role::all();
        return view('manage-admin.edit-admin',compact('users'));
    }
    public function editadminstore(Request $request,$id){
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
        ], [
            'email.unique' => 'The email address is already in use.',
        ]);
        // dd($request->all());
        // $user = new User();
        $user->name = $request->name ? $request->name :$user->name;
        $user->email = $request->email ? $request->email :$user->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return redirect()->route('manage-admin')->with('success', 'Admin Updated Successfully');
    }
    public function delete($id){
        try{
        $user = User::findOrFail($id)->where('status',false);
     
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
    public function updateUserRole(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->role_id = $request->role_id;
            $user->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
}
