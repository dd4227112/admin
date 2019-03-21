<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Permissions extends Model {

    protected $table = 'constant.permission';
    protected $fillable = [
        'name', 'display_name', 'description', 'is_super', 'permission_group_id', 'arrangement'
    ];

    public function permissionGroup() {
        return $this->belongsTo(\App\Model\PermissionGroup::class);
    }

}
