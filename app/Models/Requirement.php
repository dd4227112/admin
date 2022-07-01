<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class Requirement extends Model {

    //use \App\Traits\BelongsToUser;

    //put your code here 
    protected $table = 'requirements';

    protected $fillable = ['id', 'note','priority', 'user_id', 'contact', 'created_at', 'updated_at', 'to_user_id', 'project_id', 'due_date', 'school_id', 'status'];

  

    public function toUser() {
        return $this->belongsTo(\App\Models\User::class, 'to_user_id', 'id')->withDefault(['name' => 'Not allocated']);
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

    
    public function school() {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

    public function modules() {
        return $this->hasMany(\App\Models\ModuleTask::class, 'task_id', 'id');
    }

}
