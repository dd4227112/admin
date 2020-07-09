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
class TaskClient extends Model {

    //put your code here
    protected $table = 'tasks_clients';
    protected $fillable = ['id', 'task_id', 'client_id', 'created_at', 'updated_at'];

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function task() {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }

}
