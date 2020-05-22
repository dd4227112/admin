<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    /**
     * Generated
     */

    protected $table = 'locations';
    protected $fillable = ['id', 'long', 'lat', 'user_id'];


    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }


}
