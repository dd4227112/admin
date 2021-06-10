<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = 'admin.permissions';
    protected $fillable = ['id', 'name', 'display_name', 'description','permission_group_id'];


    public function roles() {
        return $this->belongsToMany(\App\Models\Role::class, 'permission_role', 'permission_id', 'role_id');
    }

    public function permissionRoles() {
        return $this->hasMany(\App\Models\PermissionRole::class, 'permission_id', 'id');
    }

    public function permissionGroup() {
        return $this->belongsTo(\App\Models\PermissionGroup::class, 'permission_group_id', 'id');
    }


}
