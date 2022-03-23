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
class TrainItemAllocation extends Model {

    use \App\Traits\BelongsToUser;


    //put your code here
    protected $table = 'admin.train_items_allocations';
    protected $fillable = ['id', 'train_item_id', 'user_id','client_id','max_time','school_person_allocated','task_id', 'created_at', 'updated_at','is_allocated'];


    public function trainItem() {
        return $this->belongsTo(\App\Models\TrainItem::class, 'train_item_id', 'id');
    }


      public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }
      public function task() {
        return $this->belongsTo(\App\Models\Task::class, 'task_id', 'id');
    }
}
