<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model {

    /**
     * Generated
     */

    protected $table = 'deductions';
    protected $fillable = ['id', 'name', 'percent', 'amount', 'description', 'is_percentage', 'category', 'bank_account_id', 'account_number'];


    public function bankAccount() {
        return $this->belongsTo(\App\Models\BankAccount::class, 'bank_account_id', 'id');
    }

    public function salaries() {
        return $this->belongsToMany(\App\Models\Salary::class, 'salary_deductions', 'deduction_id', 'salary_id');
    }

    public function users() {
        return $this->belongsToMany(\App\Models\User::class, 'user_deductions', 'deduction_id', 'user_id');
    }

    public function salaryDeductions() {
        return $this->hasMany(\App\Models\SalaryDeduction::class, 'deduction_id', 'id');
    }

    public function userDeductions() {
        return $this->hasMany(\App\Models\UserDeduction::class, 'deduction_id', 'id');
    }


}
