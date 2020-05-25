<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model {

    /**
     * Generated
     */

    protected $table = 'expense';
    protected $fillable = ['id', 'date', 'expense', 'user_id', 'expenseyear', 'note', 'is_depreciation', 'amount', 'depreciation', 'refer_expense_id', 'ref_no', 'payment_method', 'bank_account_id', 'transaction_id', 'reconciled', 'file', 'voucher_no', 'payer_name', 'recipient','payment_type_id'];


    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function referExpense() {
        return $this->belongsTo(\App\Models\ReferExpense::class, 'refer_expense_id', 'id');
    }

    public function bankAccount() {
        return $this->belongsTo(\App\Models\BankAccount::class, 'bank_account_id', 'id');
    }

     public function paymentType() {
        return $this->belongsTo(\App\Models\PaymentType::class, 'payment_type_id', 'id');
    }

}
