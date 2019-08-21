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
    
    protected $fillable = ['id', 'client_id', 'activity', 'date', 'time', 'user_id', 'priority', 'created_at', 'updated_at'];

    
    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    
    public function client() {
        return $this->belongsTo(\App\Models\User::class, 'client_id', 'id');
    }

     public function taskComments() {
        return $this->hasMany(\App\Models\TaskComment::class, 'task_id', 'id');
    }
}
