<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {

    /**
     * Generated
     */

    protected $table = 'bank_accounts';
    protected $fillable = ['id', 'number', 'branch', 'note', 'account_name', 'refer_currency_id', 'refer_bank_id', 'opening_balance'];


    public function referCurrency() {
        return $this->belongsTo(\App\Models\ReferCurrency::class, 'refer_currency_id', 'id');
    }

    public function referBank() {
        return $this->belongsTo(\App\Models\ReferBank::class, 'refer_bank_id', 'id');
    }

    public function referExpenses() {
        return $this->belongsToMany(\App\Models\ReferExpense::class, 'revenues', 'bank_account_id', 'refer_expense_id');
    }

    public function deductions() {
        return $this->hasMany(\App\Models\Deduction::class, 'bank_account_id', 'id');
    }

    public function expenses() {
        return $this->hasMany(\App\Models\Expense::class, 'bank_account_id', 'id');
    }

    public function revenues() {
        return $this->hasMany(\App\Models\Revenue::class, 'bank_account_id', 'id');
    }


}
