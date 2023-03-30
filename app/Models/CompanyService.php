<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of ClientProject
 *
 * @author hp
 */
class CompanyService extends Model {

    protected $table = 'company_services';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at', 'description','created_by'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }




}
