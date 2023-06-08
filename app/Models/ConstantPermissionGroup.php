<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstantPermissionGroup extends Model
{

    protected $table = 'constant.permission_group';

    protected $fillable = [
        'name'
    ];

    public function permissions() {
        return $this->hasMany(\App\Models\ConstantPermission::class,'permission_group_id','id');
    }
}

