<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferDesignation extends Model {

    protected $table = 'constant.refer_company_designations';
    protected $fillable = ['id', 'name', 'abbreviation', 'created_at', 'updated_at'];

   
    public function userdesignation() {
        return $this->belongsTo(\App\Models\User::class,'user_id','id');
    }


}
