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
class TaskComment extends Model {

    use \App\Traits\BelongsToUser;


    //put your code here
    protected $table = 'task_comments';
    protected $fillable = ['id', 'task_id', 'content', 'user_id', 'created_at', 'updated_at'];

    public function task() {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }

}
