<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSchool extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.client_schools';
    protected $fillable = ['id', 'client_id', 'school_id', 'created_at', 'updated_at'];

    public function school() {
        return $this->belongsTo(\App\Models\School::class);
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class);
    }

}
