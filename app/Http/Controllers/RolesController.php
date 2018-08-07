<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Permission;
use DB;
use Auth;

class RolesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $roles = Role::orderBy('id', 'DESC')->paginate(10);
        return view('roles.index', compact('roles'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->created_by = Auth::user()->id;
        $role->save();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('roles.index')
                        ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if ($id == 'shulesoft') {
            return $this->shulesoftPermission();
        } else if ($id == 'update_tag') {
            return $this->updateShuleSoftPermission();
        } else if ($id == 'addPermission') {
            return $this->addPermission();
        } else if ($id == 'removePermission') {
            return $this->removePermission();
        }

        $role = Role::find($id);
      
        $rolePermissions = Permission::join("permission_role", "permission_role.permission_id", "=", "permissions.id")
                ->where("permission_role.role_id", $id)
                ->get();

        return view('roles.show', compact('role', 'rolePermissions', 'id'));
    }

    public function addPermission() {
        $permission_id = request('id');
        $role_id = request('role_id');
        \App\Model\Permission_role::create(['permission_id' => $permission_id, 'role_id' => $role_id, 'created_by' => Auth::user()->id]);
        echo 'success';
    }

    public function removePermission() {
        $permission_id = request('id');
        $role_id = request('role_id');
        \App\Model\Permission_role::where(['permission_id' => $permission_id, 'role_id' => $role_id])->delete();
        echo 'success';
    }

    public function updateShuleSoftPermission() {
        $id = request('id');
        $new_value = request('newvalue');
        $column = request('column');
        \App\Model\Constant_permission::find($id)->update([$column => $new_value]);
    }

    public function shulesoftPermission() {
        $this->data['permission_groups'] = \App\Model\Permission_group::all();
        return view('roles.shulesoft_permission', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("permission_role")->where("permission_role.role_id", $id)
                        ->pluck('permission_role.permission_id', 'permission_role.permission_id')->toArray();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        DB::table("permission_role")->where("permission_role.role_id", $id)
                ->delete();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('roles.index')
                        ->with('success', 'Role ' . request('display_name') . ' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
                        ->with('success', 'Role deleted successfully');
    }

}
