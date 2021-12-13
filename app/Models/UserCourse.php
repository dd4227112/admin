<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model {
    
    protected $table = 'admin.user_courses';
    protected $fillable = ['id', 'user_id', 'course_id', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function course() {
        return $this->belongsTo(\App\Models\Course::class, 'course_id', 'id');
    }

}
