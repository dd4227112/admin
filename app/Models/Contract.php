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
class Contract extends Model {


    //use \App\Traits\belongsTocompanyFile;
  //  use \App\Traits\BelongsToUser;


    protected $table = 'contracts';
    protected $fillable = ['id', 'name', 'company_file_id', 'user_id', 'start_date', 'end_date', 'type', 'created_at', 'updated_at', 'note','contract_type_id'];

   public function contractType() {
        return $this->belongsTo(\App\Models\ContractType::class, 'contract_type_id', 'id')->withDefault(['name' => 'Not Defined']);
    }
 
    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id')->withDefault(['name' => 'unknown']);
    }
}
