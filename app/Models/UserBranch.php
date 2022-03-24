<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBranch extends Model {
    
    //use \App\Traits\BelongsToUser;

    /**
     * Generated
     */
    protected $table = 'user_branches';
    protected $fillable = ['id', 'branch_id', 'user_id', 'created_at', 'updated_at'];
    
    public function branch() {
        return $this->belongsTo(\App\Models\PartnerBranch::class, 'branch_id', 'id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }


}
