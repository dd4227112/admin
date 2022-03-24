<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClient extends Model {
   
    use \App\Traits\BelongsToUser;

    /**
     * Generated
     */
    protected $table = 'admin.user_clients';
    protected $fillable = ['id', 'client_id', 'user_id', 'status', 'created_at', 'updated_at'];


    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

}
