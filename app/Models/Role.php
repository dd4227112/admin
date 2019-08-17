<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    /**
     * Generated
     */

    protected $table = 'roles';
    protected $fillable = ['id', 'name', 'display_name', 'description', 'created_by'];


    public function permissions() {
        return $this->belongsToMany(\App\Models\Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function permissionRoles() {
        return $this->hasMany(\App\Models\PermissionRole::class, 'role_id', 'id');
    }

    public function roleUsers() {
        return $this->hasMany(\App\Models\RoleUser::class, 'role_id', 'id');
    }


}
