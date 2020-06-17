<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model {

    /**
     * Generated
     */

    protected $table = 'salaries';
    protected $fillable = ['id', 'user_id', 'basic_pay', 'allowance', 'gross_pay', 'pension_fund', 'deduction', 'tax', 'paye', 'net_pay', 'payment_date', 'reference', 'allowance_distribution', 'deduction_distribution', 'pension_distribution'];


    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function allowances() {
        return $this->belongsToMany(\App\Models\Allowance::class, 'salary_allowances', 'salary_id', 'allowance_id');
    }

    public function deductions() {
        return $this->belongsToMany(\App\Models\Deduction::class, 'salary_deductions', 'salary_id', 'deduction_id');
    }

    public function pensions() {
        return $this->belongsToMany(\App\Models\Pension::class, 'salary_pensions', 'salary_id', 'pension_id');
    }

    public function salaryAllowances() {
        return $this->hasMany(\App\Models\SalaryAllowance::class, 'salary_id', 'id');
    }

    public function salaryDeductions() {
        return $this->hasMany(\App\Models\SalaryDeduction::class, 'salary_id', 'id');
    }

    public function salaryPensions() {
        return $this->hasMany(\App\Models\SalaryPension::class, 'salary_id', 'id');
    }


}
