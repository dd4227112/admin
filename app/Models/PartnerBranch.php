<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerBranch extends Model {

    /**
     * Generated
     */
    protected $table = 'partner_branches';
    protected $fillable = ['id', 'name', 'status', 'email', 'phone_number', 'partner_id', 'district_id', 'created_at', 'updated_at'];
    
    public function partner() {
        return $this->belongsTo(\App\Models\Partner::class, 'partner_id', 'id');
    }

    public function district() {
            return $this->belongsTo(\App\Models\District::class, 'district_id', 'id');
        }
    
        public function school() {
            return $this->hasMany(\App\Models\PartnerSchool::class, 'branch_id', 'id');
        }
            
        public function user() {
            return $this->hasMany(\App\Models\PartnerUser::class, 'branch_id', 'id');
        }
}
