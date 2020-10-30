<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class IntegrationRequest extends Model {

    /**
     * Generated
     */
    
    /**
     *
     * WITH BASIC DESIGN, one table will be used, but in the future we will use two different tables to track approval
     */
    
    protected $table = 'integration_requests';
    protected $fillable = ['id', 'client_id', 'user_id', 'shulesoft_approved', 'bank_approved', 'schema_name', 'created_at','updated_at','approval_user_id','refer_bank_id','bank_account_id','bank_accounts_integration_id'];

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'User Not Defined']);
    }

    public function banks() {
        return $this->belongsTo(\App\Models\IntegrationBankAccount::class, 'id', 'integration_request_id')->withDefault(['name' => 'User Not Defined']);
    }

 
}
