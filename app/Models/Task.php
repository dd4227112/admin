<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class Task extends Model {

    //put your code here
    protected $table = 'tasks';
    protected $fillable = ['id', 'client_id', 'activity', 'date', 'time', 'user_id', 'priority', 'created_at', 'updated_at', 'task_type_id', 'to_user_id','school_id'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id')->withDefault(['name'=>'not allocated, sales request']);
    }

    public function taskComments() {
        return $this->hasMany(\App\Models\TaskComment::class, 'task_id', 'id');
    }

    public function toUser() {
        return $this->belongsTo(\App\Models\User::class, 'to_user_id', 'id');
    }

    public function taskType() {
        return $this->belongsTo(\App\Models\TaskType::class, 'task_type_id', 'id');
    }

}
