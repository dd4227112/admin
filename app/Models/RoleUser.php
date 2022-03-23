<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

    use \App\Traits\BelongsToUser;


    /**
     * Generated
     */
    protected $table = 'role_user';
    protected $fillable = ['user_id', 'role_id'];

    public function role() {
        return $this->belongsTo(\App\Models\Role::class, 'role_id', 'id');
    }


}
