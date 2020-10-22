<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationRequestDocument extends Model {

    /**
     * Generated
     */
    
    /**
     *
     * WITH BASIC DESIGN, one table will be used, but in the future we will use two different tables to track approval
     */
    
    protected $table = 'integration_requests_documents';
    protected $fillable = ['id', 'integration_request_id', 'integration_bank_document_id', 'created_at','updated_at'];
    
    public function request() {
        return $this->belongsTo(\App\Models\IntegrationRequest::class, 'integration_request_id', 'id');
    }

    public function bankdocs() {
        return $this->belongsTo(\App\Models\IntegrationBankDocument::class, 'integration_bank_document_id', 'id')->withDefault(['name' => 'User Not Defined']);
    }

}
