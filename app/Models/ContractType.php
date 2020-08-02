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
class ContractType extends Model {

    protected $table = 'contracts_types';
    protected $fillable = ['id', 'name', 'note', 'created_at', 'updated_at'];

}
