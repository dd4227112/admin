<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model {

    /**
     * Generated
     */

    protected $table = 'revenues';
    protected $fillable = ['id', 'payer_name', 'payer_phone', 'payer_email', 'refer_expense_id', 'amount', 'user_id', 'payment_method', 'transaction_id', 'bank_account_id', 'invoice_number', 'note', 'payment_date', 'reconciled', 'number', 'date', 'payment_type_id'];


    public function referExpense() {
        return $this->belongsTo(\App\Models\ReferExpense::class, 'refer_expense_id', 'id');
    }

    public function bankAccount() {
        return $this->belongsTo(\App\Models\BankAccount::class, 'bank_account_id', 'id');
    }


}
