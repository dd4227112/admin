<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    /**
     * Generated
     */
    protected $table = 'payments';
    protected $fillable = ['id', 'invoice_id', 'amount', 'transaction_fee', 'method', 'transaction_id', 
    'mobile_transaction_id', 'transaction_time', 'account_number', 'token', 'bank_account_id', 'status', 
    'reconciled', 'note', 'financial_entity_id', 'checksum', 'payment_type', 'amount_type', 'currency', 
    'receipt_sent','client_id'];
    

    public function invoice() {
        return $this->belongsTo(\App\Models\Invoice::class, 'invoice_id', 'id');
    }
    public function bankAccount() {
        return $this->belongsTo(\App\Models\BankAccount::class, 'bank_account_id', 'id')->withDefault(['account_name'=>'NMB BANK']);
    }

    public function invoiceFees() {
        return $this->belongsToMany(\App\Models\InvoiceFee::class, 'invoice_fees_payments', 'payment_id', 'invoice_fee_id');
    }

    public function invoiceFeesPayments() {
        return $this->hasMany(\App\Models\InvoiceFeesPayment::class, 'payment_id', 'id');
    }

     public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function dueAmounts() {
        return $this->belongsToMany(\App\Models\DueAmount::class, 'due_amounts_payments', 'payment_id', 'due_amount_id');
    }

     public function advancePayments() {
        return $this->hasMany(\App\Models\AdvancePayment::class, 'payment_id', 'id');
    }

}
