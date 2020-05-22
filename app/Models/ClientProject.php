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
class ClientProject extends Model {

    protected $table = 'client_projects';
    protected $fillable = ['id', 'client_id', 'project_id', 'created_at', 'updated_at', 'note'];

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function project() {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'id');
    }

}
