<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class School extends Model {

    protected $table = 'admin.schools';
    protected $fillable = ['id', 'name', 'region', 'schema_name', 'status', 'created_at', 'updated_at'];

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
