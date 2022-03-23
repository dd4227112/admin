<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerUser extends Model {


    use \App\Traits\BelongsToUser;

    /**
     * Generated
     */
    protected $table = 'partner_users';
    protected $fillable = ['id', 'status', 'user_id', 'branch_id', 'created_at', 'updated_at'];
    
    public function branch() {
        return $this->belongsTo(\App\Models\PartnerBranch::class, 'branch_id', 'id');
    }

}
