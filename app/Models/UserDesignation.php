<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDesignation extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.user_designation';
    protected $fillable = ['id','user_id','designation_id', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }


    public function designation() {
        return $this->belongsTo(\App\Models\ReferDesignation::class, 'designation_id', 'id');
    }

}
