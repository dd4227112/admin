<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model {

    /**
     * Generated
     */
    protected $table = 'districts';
    protected $fillable = ['id', 'name', 'region_id', 'created_at', 'updated_at'];
    
    public function region() {
        return $this->belongsTo(\App\Models\Region::class, 'region_id', 'id');
    }

}
