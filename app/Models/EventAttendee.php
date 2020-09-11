<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class EventAttendee extends Model {
   
    //put your code here
    protected $table = 'event_attendees';
    protected $fillable = ['id','name', 'phone', 'email', 'position', 'school_id', 'event_id','source', 'status', 'created_at', 'updated_at'];

    public function event() {
        return $this->belongsTo(\App\Models\Events::class, 'event_id', 'id');
    }

    public function school() {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id')->withDefault(['name' => 'Not Defined']);
    }


}
