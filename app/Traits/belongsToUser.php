<?php 

namespace App\Traits;

trait BelongsToUser {

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }
}