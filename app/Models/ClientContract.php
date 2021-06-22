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
class ClientContract extends Model {

    protected $table = 'admin.client_contracts';
    protected $fillable = ['id', 'client_id', 'contract_id', 'created_at', 'updated_at', 'note'];

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function contract() {
        return $this->belongsTo(\App\Models\Contract::class, 'contract_id', 'id');
    }

}
