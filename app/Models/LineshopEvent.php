<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class LineshopEvent extends Model {

   // use \App\Traits\BelongsToUser;

   
    //put your code here
    protected $table = 'lineshop_events';
    protected $fillable = ['id','title', 'note', 'attach_id', 'event_date', 'start_time', 'end_time', 'status', 'file_id', 'category', 'user_id', 'department_id', 'created_at', 'updated_at','meeting_link'];


    public function department() {
        return $this->belongsTo(\App\Models\Department::class, 'department_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

    public function file() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'file_id', 'id')->withDefault(['name' => 'Not Defined']);
    }
    
    public function attach() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'attach_id', 'id')->withDefault(['path'=>'not defined']);
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'unknown']);
    }
}
