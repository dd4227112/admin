<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationBankAccount extends Model {

    /**
     * Generated
     */
    protected $table = 'bank_accounts_integrations';
    protected $fillable = ['id', 'account_number', 'branch', 'account_name', 'refer_currency_id', 'client_id', 'refer_bank_id', 'opening_balance','integration_request_id','schema_name', 'created_at', 'updated_at'];
   
    public function referCurrency() {
        return $this->belongsTo(\App\Models\ReferCurrency::class, 'refer_currency_id', 'id');
    }

    public function referBank() {
        return $this->belongsTo(\App\Models\ReferBank::class, 'refer_bank_id', 'id');
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function requests() {
        return $this->belongsTo(\App\Models\IntegrationRequest::class, 'integration_request_id', 'id');
    }
}
