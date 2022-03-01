<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class Requirement extends Model {

    //put your code here
    protected $table = 'requirements';
    protected $fillable = ['id', 'note', 'user_id', 'contact', 'created_at', 'updated_at', 'to_user_id', 'school_id', 'status'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Not allocated']);
    }

    public function toUser() {
        return $this->belongsTo(\App\Models\User::class, 'to_user_id', 'id')->withDefault(['name' => 'Not allocated']);
    }

    
    public function school() {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id')->withDefault(['name' => 'Not allocated']);
    }

    public function modules() {
        return $this->hasMany(\App\Models\ModuleTask::class, 'task_id', 'id');
    }

}
