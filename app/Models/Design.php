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
class Design extends Model {

    use \App\Traits\BelongsToUser;

    //put your code here
    protected $table = 'designs';
    protected $fillable = ['id', 'name', 'note', 'attach', 'user_id', 'type', 'created_at', 'updated_at'];

  

    public function task() {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }

}
