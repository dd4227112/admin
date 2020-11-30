<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClient extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.user_clients';
    protected $fillable = ['id', 'client_id', 'user_id', 'status', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

}
