<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class LineshopEventAttendee extends Model {
   
    //put your code here
    protected $table = 'lineshop_event_attendees';
    protected $fillable = ['id','name', 'phone', 'email', 'position', 'pharmacy_id', 'event_id','source', 'status', 'created_at', 'updated_at'];

    public function event() {
        return $this->belongsTo(\App\Models\LineshopEvent::class, 'event_id', 'id');
    }

    public function pharmacy() {
        return $this->belongsTo(\App\Models\Pharmacies::class, 'pharmacy_id', 'id')->withDefault(['name' => 'Not Defined']);
    }


}
