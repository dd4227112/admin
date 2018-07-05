<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission_group extends Model
{
     protected $table = 'constant.permission_group';
     
     public function permission() {
         return $this->hasMany('\App\Model\Constant_permission');
     }
}
