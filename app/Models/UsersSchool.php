<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSchool extends Model {

    /**
     * Generated
     */
    protected $table = 'users_schools';
    protected $fillable = ['id', 'user_id', 'school_id','client_id','role_id', 'status', 'created_at', 'updated_at'];

    public function school() {
        return $this->belongsTo(\App\Models\School::class);
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function role() {
        return $this->belongsTo(\App\Models\Role::class);
    }

}
