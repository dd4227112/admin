<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceFeesPayment extends Model {

    /**
     * Generated
     */
    protected $table = 'invoice_fees_payments';
    protected $fillable = ['id', 'paid_amount', 'invoice_fee_id', 'payment_id', 'status'];

    public function payment() {
        return $this->belongsTo(\App\Models\Payment::class, 'payment_id', 'id');
    }
    
    public function invoiceFee() {
        return $this->belongsTo(\App\Models\InvoiceFee::class, 'invoice_fee_id', 'id');
    }
}
