<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstantPermission extends Model {

    protected $table = 'constant.permission';
    protected $fillable = ['id', 'name', 'display_name', 'description','permission_group_id'];

    public function permissionGroup() {
        return $this->belongsTo(\App\Models\ConstantPermissionGroup::class, 'permission_group_id', 'id');
    }


}
