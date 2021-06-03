<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientJobCard extends Model {

    protected $table = 'admin.client_job_cards';
    protected $fillable = ['id', 'client_id', 'created_by','date','created_at', 'updated_at','company_file_id'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class,'created_by','id');
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class,'client_id','id');
    }

    public function companyFile(){
        return $this->belongsTo(\App\Models\CompanyFile::class,'company_file_id','id');
    }

}
