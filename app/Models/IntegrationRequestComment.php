<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class IntegrationRequestComment extends Model {

    /**
     *
     * WITH BASIC DESIGN, one table will be used, but in the future we will use two different tables to track approval
     */
    
    protected $table = 'integration_request_comments';
    protected $fillable = ['id', 'user_id', 'integration_request_id', 'comment', 'status', 'created_at','updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'User Not Defined']);
    }

    public function requests() {
        return $this->belongsTo(\App\Models\IntegrationRequest::class, 'integration_request_id', 'id');
    }

 
}