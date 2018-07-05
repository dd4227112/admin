<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Constant_permission extends Model
{
    
     protected $table = 'constant.permission';
     
    protected $guarded = ['id'];
    public $timestamps=false;
}
