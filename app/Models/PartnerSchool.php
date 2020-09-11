<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerSchool extends Model {

    /**
     * Generated
     */
    protected $table = 'partner_schools';
    protected $fillable = ['id', 'account_name', 'account_number', 'status', 'school_id', 'branch_id', 'created_at', 'updated_at'];
    
    public function branch() {
        return $this->belongsTo(\App\Models\PartnerBranch::class, 'branch_id', 'id');
    }

    public function school() {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id');
    }

}
