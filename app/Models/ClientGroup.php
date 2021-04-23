<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientGroup extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.client_groups';
    protected $fillable = ['id', 'client_id', 'group_id', 'created_at', 'updated_at'];

    public function group() {
        return $this->belongsTo(\App\Models\Group::class);
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class);
    }

}
