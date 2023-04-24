<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSchool extends Model {

    protected $table = 'admin.client_schools';
    protected $fillable = ['id', 'client_id', 'school_id', 'created_at', 'updated_at'];

    public function school() {
        return $this->belongsTo(\App\Models\User::class, 'school_id', 'id')->withDefault(['name'=>'Not Defined']);
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id')->withDefault(['name'=>'Not Defined']);
    }

}
