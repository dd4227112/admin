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
class TempClients extends Model {

    //put your code here
    protected $table = 'admin.temp_clients';
    protected $fillable = ['id', 'name','email','phone','school_id','user_id','reference','date','due_date','account_year_id',
                           'project_id', 'amount','created_at','updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function school() {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id');
    }

      public function account_year() {
        return $this->belongsTo(\App\Models\AccountYear::class, 'account_year_id', 'id');
    }

       public function project() {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'id');
    }

}
