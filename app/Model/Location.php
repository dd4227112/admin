<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'long', 'lat', 'user_id'
    ];

    public function user(){
        return $this->belongsTo("App\Model\User");
    }
}
