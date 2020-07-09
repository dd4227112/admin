<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of TaskComment
 *
 * @author hp
 */
class TaskSchool extends Model {

    //put your code here
    protected $table = 'tasks_schools';
    protected $fillable = ['id', 'task_id', 'school_id', 'created_at', 'updated_at'];

    public function school() {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id');
    }

    public function task() {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }

}
