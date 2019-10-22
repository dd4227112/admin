<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    /**
     * Generated
     */

    protected $table = 'permissions';
    protected $fillable = ['id', 'name', 'display_name', 'description'];


    public function roles() {
        return $this->belongsToMany(\App\Models\Role::class, 'permission_role', 'permission_id', 'role_id');
    }

    public function permissionRoles() {
        return $this->hasMany(\App\Models\PermissionRole::class, 'permission_id', 'id');
    }


}
