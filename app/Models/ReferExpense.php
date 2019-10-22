<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferExpense extends Model {

    /**
     * Generated
     */

    protected $table = 'refer_expense';
    protected $fillable = ['id', 'name', 'financial_category_id', 'note', 'status', 'code', 'date', 'open_balance', 'account_group_id'];


    public function accountGroup() {
        return $this->belongsTo(\App\Models\AccountGroup::class, 'financial_category_id', 'id');
    }

    public function financialCategory() {
        return $this->belongsTo(\App\Models\FinancialCategory::class, 'financial_category_id', 'id');
    }

    public function bankAccounts() {
        return $this->belongsToMany(\App\Models\BankAccount::class, 'revenues', 'refer_expense_id', 'bank_account_id');
    }

    public function expenses() {
        return $this->hasMany(\App\Models\Expense::class, 'refer_expense_id', 'id');
    }

    public function revenues() {
        return $this->hasMany(\App\Models\Revenue::class, 'refer_expense_id', 'id');
    }


}
