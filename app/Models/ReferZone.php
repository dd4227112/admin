<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferZone extends Model {

    protected $table = 'constant.refer_zones';
    protected $fillable = ['id', 'name', 'country_id', 'created_at', 'updated_at'];

    public function region() {
        return $this->hasMany(\App\Models\Region::class);
    }

    public function country() {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }

}
