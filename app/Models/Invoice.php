<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    use \App\Traits\BelongsToUser;


    /**
     * Generated
     */
    protected $table = 'invoices';
    protected $fillable = ['id', 'reference', 'client_id', 'title', 'optional_name', 'date', 'status', 'year', 'active', 'sync', 'return_message', 'push_status',
        'note', 'type', 'currency', 'user_id', 'due_date', 'account_year_id','order_id', 'amount','token','qr','gateway_buyer_uuid','payment_gateway_url','methods',
        'source','pay_status','invoice_type'];

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function invoiceFees() {
        return $this->hasMany(\App\Models\InvoiceFee::class, 'invoice_id', 'id');
    }

    public function payments() {
        return $this->hasMany(\App\Models\Payment::class, 'invoice_id', 'id');
    }

    public function accountYear() {
        return $this->belongsTo(\App\Models\AccountYear::class, 'account_year_id', 'id');
    }

    public function invoiceType() {
        return $this->belongsTo(\App\Models\InvoiceType::class, 'invoice_type', 'id');
    }


}
