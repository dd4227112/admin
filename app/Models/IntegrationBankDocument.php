<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationBankDocument extends Model {

    /**
     * Generated
     */
    
    /**
     *
     * WITH BASIC DESIGN, one table will be used, but in the future we will use two different tables to track approval
     */
    
    protected $table = 'integration_bank_documents';
    protected $fillable = ['id',  'created_by', 'company_file_id',  'created_at','updated_at'];

    public function companyfile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id')->withDefault(['name' => 'User Not Defined']);
    }


}
