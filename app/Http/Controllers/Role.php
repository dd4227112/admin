<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;

class Role extends Controller
{  
    public function __construct() {
        $this->middleware('auth');
    }

    public function userpermission() {
        $id = request()->segment(3);
        $this->data['set']  = (int) $id;
        $this->data['roles']  = \App\Models\Role::orderBy('id', 'DESC')->paginate(12);
        $this->data['permission']  = \App\Models\Permission::get();
        $this->data['Permissionsgroup'] = \App\Models\PermissionGroup::get();
        return view('users.user_permission', $this->data);
   }


  public function storeRoles(Request $request){
    $this->validate($request, [
        'name' => 'required|unique:roles,name',
        'display_name' => 'required',
        'description' => 'required',
    ]);
    $role = new \App\Models\Role();
    $role->name = $request->input('name');
    $role->display_name = $request->input('display_name');
    $role->description = $request->input('description');
    $role->created_by = Auth::user()->id;
    $role->save();
    return redirect()->back()->with('success', 'Role created successfully');
  }


public function storePermission() {
    $role = new \App\Models\PermissionRole();
    $role->permission_id = request('perm_id');
    $role->role_id = request('role_id');
    $role->created_by = Auth::user()->id;
    $role->save();
    echo 'Permission created successfully';
}


public function removePermission() {
    $permission_id = request('perm_id');
    $role_id = request('role_id');
    \App\Models\PermissionRole::where(['permission_id' => $permission_id, 'role_id' => $role_id])->delete();
    echo 'success';
}


}