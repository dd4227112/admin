<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minutes extends Model {

    /**
     * Generated
     */

    protected $table = 'meeting_minutes';
    protected $fillable = ['id', 'date', 'title', 'note','attached', 'department_id', 'start_time', 'end_time', 'created_at'];
/*
    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    */
    public function department() {
        return $this->belongsTo(\App\Models\Department::class, 'department_id', 'id');
    }

}
