<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model {

   // use \App\Traits\BelongsToUser;

    
    protected $table = 'admin.user_courses';
    protected $fillable = ['id', 'user_id', 'course_id', 'created_at', 'updated_at'];

    public function course() {
        return $this->belongsTo(\App\Models\Course::class, 'course_id', 'id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

}
