<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * Generated
     */

    protected $table = 'users';
    protected $fillable = ['id', 'firstname', 'middlename', 'lastname', 'email', 'password', 'rolename', 'type', 'name', 'remember_token', 'dp', 'phone', 'town', 'created_by', 'photo'];


    public function deductions() {
        return $this->belongsToMany(\App\Models\Deduction::class, 'user_deductions', 'user_id', 'deduction_id');
    }

    public function pensions() {
        return $this->belongsToMany(\App\Models\Constant.pension::class, 'user_pensions', 'user_id', 'pension_id');
    }

    public function allowances() {
        return $this->belongsToMany(\App\Models\Allowance::class, 'user_allowances', 'user_id', 'allowance_id');
    }

    public function locations() {
        return $this->hasMany(\App\Models\Location::class, 'user_id', 'id');
    }

    public function invoices() {
        return $this->hasMany(\App\Models\Invoice::class, 'user_id', 'id');
    }

    public function expenses() {
        return $this->hasMany(\App\Models\Expense::class, 'user_id', 'id');
    }

    public function userDeductions() {
        return $this->hasMany(\App\Models\UserDeduction::class, 'user_id', 'id');
    }

    public function userPensions() {
        return $this->hasMany(\App\Models\UserPension::class, 'user_id', 'id');
    }

    public function salaries() {
        return $this->hasMany(\App\Models\Salary::class, 'user_id', 'id');
    }

    public function userAllowances() {
        return $this->hasMany(\App\Models\UserAllowance::class, 'user_id', 'id');
    }


}
