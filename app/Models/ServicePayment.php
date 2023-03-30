<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model {

    /**
     * Generated
     */
    protected $table = 'service_payments';
    protected $fillable = ['id', 'invoice_id', 'service_id', 'unit_amount', 'created_at', 'updated_at','status'];

    public function invoice() {
        return $this->belongsTo(\App\Models\Invoice::class, 'invoice_id', 'id');
    }

     public function service() {
        return $this->belongsTo(\App\Models\CompanyService::class, 'service_id', 'id');
    }

}
