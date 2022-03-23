<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class Task extends Model {

    use \App\Traits\BelongsToUser;


    //put your code here
    protected $table = 'tasks';
    protected $fillable = ['id','activity', 'client_id', 'action', 'date', 'time', 'user_id','next_action', 'priority', 'created_at', 'updated_at',
      'task_type_id','to_user_id','school_id','start_date','end_date','status','slot_id','ticket_no','budget','remainder_date','remainder'];


    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

    public function taskComments() {
        return $this->hasMany(\App\Models\TaskComment::class, 'task_id', 'id');
    }

    public function taskStaff() {
        return $this->hasMany(\App\Models\TaskStaff::class, 'task_id', 'id');
    }

    public function toUser() {
        return $this->belongsTo(\App\Models\User::class, 'to_user_id', 'id');
    }

    public function taskType() {
        return $this->belongsTo(\App\Models\TaskType::class, 'task_type_id', 'id')->withDefault(['name' => 'Not allocated']);
    }

    public function modules() {
        return $this->hasMany(\App\Models\ModuleTask::class, 'task_id', 'id');
    }

    public function taskUsers() {
        return $this->hasMany(\App\Models\TaskUser::class, 'task_id', 'id');
    }

      public function slot() {
        return $this->belongsTo(\App\Models\Slot::class, 'slot_id', 'id')->withDefault(['start_time' => 'Not defined']);
    }
}
