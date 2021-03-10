<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model {

    /**
     * Generated
     */

    protected $table = 'allowances';
    protected $fillable = ['id', 'name', 'amount', 'percent', 'description', 'is_percentage', 'type', 'pension_included', 'category'];

    public function salaries() {
        return $this->belongsToMany(\App\Models\Salary::class, 'salary_allowances', 'allowance_id', 'salary_id');
    }

    public function users() {
        return $this->belongsToMany(\App\Models\User::class, 'user_allowances', 'allowance_id', 'user_id');
    }

    public function salaryAllowances() {
        return $this->hasMany(\App\Models\SalaryAllowance::class, 'allowance_id', 'id');
    }

    public function userAllowances() {
        return $this->hasMany(\App\Models\UserAllowance::class, 'allowance_id', 'id');
    }


}
