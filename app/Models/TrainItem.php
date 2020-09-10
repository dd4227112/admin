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
class TrainItem extends Model {

    //put your code here
    protected $table = 'train_items';
    protected $fillable = ['id', 'time', 'content', 'created_at', 'updated_at'];
    
    public function trainItemAllocation() {
        return $this->hasMany(\App\Models\TrainItemAllocation::class);
    }

}
