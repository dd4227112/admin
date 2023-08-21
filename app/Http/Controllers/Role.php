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
        $id = $this->data['role_id']= request()->segment(3);
        $this->data['set']  = (int) $id;
        $this->data['roles']  = \App\Models\Role::orderBy('id', 'DESC')->paginate(20);
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
    $role->created_by = \Auth::user()->id;
    $role->save();
    echo 'Permission created successfully';
}


public function removePermission() {
    $permission_id = request('perm_id');
    $role_id = request('role_id');
    \App\Models\PermissionRole::where(['permission_id' => $permission_id, 'role_id' => $role_id])->delete();
    echo 'Permission removed successfully';
}
 public function manage_permission(){
    $this->data['Permissiongroup'] =[];
    $this->data['Permissionsgroups'] =\App\Models\ConstantPermissionGroup::get();
    $this->data['permissions'] =[];
    return view('users.permissions.manage_permission', $this->data);

 }
 public function getPermisssions(){
    $id = request('permission');
    if(!$id){
        return redirect('role/manage_permission');
    }
    $this->data['Permissionsgroups'] =\App\Models\ConstantPermissionGroup::get();
    $this->data['Permissiongroup'] =\App\Models\ConstantPermissionGroup::where('id',$id)->first();
    $this->data['permissions'] =\App\Models\ConstantPermission::where('permission_group_id', $id)->get();
    return view('users.permissions.manage_permission', $this->data);


 }
 public function add_permission(){
    if($_POST){
        $data =[
            'name' =>request('name'),
            'display_name'=>request('display_name'),
            'description' =>request('description'),
            'permission_group_id' =>request('permission_group_id'),
        ];
        \App\Models\ConstantPermission::insert($data);
        return redirect()->back()->with('success', 'Permission added successfully');
    }
    $this->data['Permissiongroup'] =[];
    $this->data['Permissionsgroups'] =\App\Models\ConstantPermissionGroup::get();
 return view('users.permissions.addPermission', $this->data);
 }
 public function storePermissionGroup(Request $request){
        
    $this->validate($request, [
        'name' => 'required|unique:permission_groups,name',
    ]);
    $permission_group = new \App\Models\ConstantPermissionGroup();
    $permission_group->name = $request->input('name');
    $permission_group->save();
   
    return redirect()->back()->with('success', 'New Permission Group created successfully');
  }
  public function manage_quarters()
  {
    $data['quarters'] = DB::table('year_quarters')->first();
    return view('users.permissions.qaurter', $data);
  } 
public function updateQuarter(request $request){
    $data = [
        'id' => $request->id,
        'name' =>$request->name,
        'start_date' =>$request->start_date,
        'end_date' =>$request->end_date,
    ];
    DB::table('admin.year_quarters')->where('id', $data['id'])->update($data);
   return redirect()->back()->with('success', "Current Quarter Updated Successfully");
}
    public function saveQuarter(request $request){
        $data = [
            'name' =>$request->name,
            'start_date' =>$request->start_date,
            'end_date' =>$request->end_date,
        ];
        DB::table('admin.year_quarters')->insert($data);
    return redirect()->back()->with('success', "Current Quarter Added Successfully");
    }

}