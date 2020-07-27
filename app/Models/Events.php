<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class Events extends Model {
   
    //put your code here
    protected $table = 'events';
    protected $fillable = ['id','title', 'note', 'attach', 'event_date', 'start_time', 'end_time', 'status', 'user_id', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'User Not allocated']);
    }


}
