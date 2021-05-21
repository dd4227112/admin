<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneManager extends Model {

    /**
     * Generated
     */
    protected $table = 'zone_managers';
    protected $fillable = ['id', 'zone_id', 'user_id', 'created_at', 'updated_at'];
    
    public function zone() {
        return $this->belongsTo(\App\Models\Zone::class, 'zone_id', 'id');
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class,'user_id', 'id');
    }
}
