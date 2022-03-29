<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinuteUser extends Model {

   // use \App\Traits\BelongsToUser;


    /**
     * Generated
     */

    protected $table = 'minute_users';
    protected $fillable = ['id', 'user_id', 'minute_id', 'created_at'];


    public function minute() {
        return $this->belongsTo(\App\Models\Minutes::class, 'minute_id', 'id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

}
