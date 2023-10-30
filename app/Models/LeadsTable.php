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
class LeadsTable extends Model {
    protected $table = 'leads_table';
    protected $fillable = ['id', 'name', 'phone', 'school_name', 'region', 'district', 'ward', 'user_id', 'student_number', 'created_at', 'updated_at'];
    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

}
