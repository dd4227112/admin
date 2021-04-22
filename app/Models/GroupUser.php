<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model {

    /**
     * Generated
     */
    protected $table = 'group_users';
    protected $fillable = ['id', 'status', 'user_id', 'group_id', 'created_at', 'updated_at'];
    
    public function branch() {
        return $this->belongsTo(\App\Models\Group::class, 'group_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

}
