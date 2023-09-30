<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model {

    /**
     * Generated
     */
    protected $table = 'wards';
    protected $fillable = ['id', 'name', 'district_id', 'created_at', 'updated_at'];
    
    public function district() {
        return $this->belongsTo(\App\Models\District::class, 'district_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

    public function schools() {
        return $this->hasMany(\App\Models\School::class,'ward_id', 'id');
    }

    public function pharmacies() {
        return $this->hasMany(\App\Models\Pharmacies::class,'ward_id', 'id');
    }
}
