<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerUser extends Model {

    /**
     * Generated
     */
    protected $table = 'partner_users';
    protected $fillable = ['id', 'status', 'user_id', 'branch_id', 'created_at', 'updated_at'];
    
    public function branch() {
        return $this->belongsTo(\App\Models\PartnerBranch::class, 'branch_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

}
