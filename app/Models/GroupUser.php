<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model {

    use \App\Traits\BelongsToUser;


    /**
     * Generated
     */
    protected $table = 'group_users';
    protected $fillable = ['id', 'status', 'user_id', 'group_id', 'created_at', 'updated_at'];
    
    public function branch() {
        return $this->belongsTo(\App\Models\Group::class, 'group_id', 'id');
    }



}
