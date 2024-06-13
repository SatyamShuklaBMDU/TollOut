<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function index(){
        return view('role.add-role');
    }
    public function store(Request $request){
        $request->validate([
            'role' => 'required|string|unique:roles,role',
            'permission' => 'required',
        ], [
            'role.unique' => 'This role is already Created.',
        ]);

        $user = new Role();
        $user->role = $request->role;
        $user->permissions = json_encode($request->permission);
        $user->save();
        return redirect()->route('all-role')->with('success', 'Role Added Successfully');
    }
    public function roles(){
        $users = Role::where('status','1')->latest()->get();
        return view('role.all-role',compact('users'));
    }
    public function edit($id){
        $did = decrypt($id);
        $users = Role::findOrFail($did);
        $permission = json_decode($users->permissions,true);
        return view('role.edit-role',compact('users','permission'));
        
    }
    public function editrolestore(Request $request,$id){
        $did = decrypt($id);
        $user = Role::findOrFail($did);
        $request->validate([
            'role' => 'required|string|unique:roles,role,'.$user->id,
            'permission' => 'required',
        ], [
            'role.unique' => 'This role is already Created.',
        ]);
        $user->role = $request->role ? $request->role :$user->role;
        $user->permissions = json_encode($request->permission ? $request->permission :$user->permissions);
        $user->save();
        return redirect()->route('all-role')->with('success', 'Role Updated Successfully');
    }
    public function delete($id){
        
        try{  
        $user = Role::findOrFail($id);
        $role= User::where('role_id',$id)->delete();
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
        $roles = Role::where('role','!=','Super admin')->get();
        $startDate = $request->start;
        $endDate = $request->end;
        $users = Role::whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($users);
        return view('manage-admin.manage-admin', ['users' => $users, 'start' => $startDate, 'end' => $endDate,'roles'=>$roles]);
    }
}
