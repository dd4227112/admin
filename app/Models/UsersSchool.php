<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSchool extends Model {
  
    //use \App\Traits\BelongsToUser;

    /**
     * Generated
     */
    protected $table = 'users_schools';
    protected $fillable = ['id', 'user_id', 'school_id','client_id','role_id', 'status', 'created_at', 'updated_at'];

    public function school() {
        return $this->belongsTo(\App\Models\School::class);
    }


    public function role() {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

}
