<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {

    /**
     * Generated
     */

    protected $table = 'admin.permission_role';
    protected $fillable = ['permission_id','role_id','created_by','id','created_at','updated_at'];

    public function role() {
        return $this->belongsTo(\App\Models\Role::class, 'role_id', 'id');
    }

    public function permission() {
        return $this->belongsTo(\App\Models\Permission::class, 'permission_id', 'id');
    }


}
