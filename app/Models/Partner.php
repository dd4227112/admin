<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model {

    /**
     * Generated
     */
    protected $table = 'partners';
    protected $fillable = ['id', 'name', 'status', 'email', 'phone_number', 'webstite', 'country_id', 'created_at', 'updated_at'];
    
    public function country() {
            return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
        }

        public function branch() {
            return $this->hasMany(\App\Models\PartnerBranch::class, 'partner_id', 'id');
        }
}
