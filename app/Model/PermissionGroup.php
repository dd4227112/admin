<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model {

    protected $table = 'constant.permission_group';
    protected $fillable = [
        'name', 'module_id'
    ];

    public function permission() {
        return $this->hasMany('\App\Model\Permissions');
    }

}
