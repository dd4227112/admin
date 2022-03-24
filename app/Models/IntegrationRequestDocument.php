<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationRequestDocument extends Model {
   
    use \App\Traits\belongsTocompanyFile;

    /**
     * Generated
     */
    
    
    protected $table = 'integration_requests_documents';
    protected $fillable = ['id', 'integration_request_id', 'company_file_id', 'created_at','updated_at'];
    
    public function request() {
        return $this->belongsTo(\App\Models\IntegrationRequest::class, 'integration_request_id', 'id');
    }

    
}
