<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {

    /**
     * Generated
     */
    protected $table = 'regions';
    protected $fillable = ['id', 'name', 'country_id', 'created_at', 'updated_at'];
    
    public function country() {
            return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id')->withDefault(['name' => 'Tanzania']);
        }

}
