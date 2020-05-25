<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersSchool extends Model {

    protected $table = 'admin.users_schools';
    protected $fillable = ['id', 'school_id', 'user_id', 'role_id', 'status', 'created_at', 'updated_at'];

    public function school() {
        return $this->belongsTo(\App\Model\School::class);
    }

    public function user() {
        return $this->belongsTo(\App\Model\User::class);
    }

    public function role() {
        return $this->belongsTo(\App\Models\Role::class);
    }

}
