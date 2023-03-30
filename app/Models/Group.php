<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    /**
     * Generated
     */
    protected $table = 'groups';
    protected $fillable = ['id', 'name', 'status', 'email', 'phone_number', 'note', 'created_at', 'updated_at'];
    
        public function clients() {
            return $this->hasMany(\App\Models\ClientGroup::class, 'partner_id', 'id');
        }
}
