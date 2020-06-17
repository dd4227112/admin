<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolContact extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.school_contacts';
    protected $fillable = ['id', 'name', 'school_id', 'email', 'phone', 'created_at', 'updated_at','user_id','title'];

    public function school() {
        return $this->belongsTo(\App\Models\School::class);
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

}