<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * Generated
     */
    protected $table = 'users';
    protected $fillable = ['id', 'firstname', 'middlename', 'lastname', 'email', 'password', 'role_id', 'type', 'name', 
    'remember_token', 'dp', 'phone', 'town', 'created_by', 'photo','about','salary','sex','skills','marital','date_of_birth',
    'personal_email','tshirt_size','joining_date','contract_end_date','academic_certificates','medical_report','driving_license',
    'valid_passport','next_kin','personal_email','employment_category','national_id','position','company_file_id','designation_id',
    'bank_name','bank_account','employment_contract'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function name() {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }

    public function location() {
        return $this->hasMany('App\Model\Location');
    }

    public function deductions() {
        return $this->belongsToMany(\App\Models\Deduction::class, 'user_deductions', 'user_id', 'deduction_id');
    }

    public function pensions() {
        return $this->belongsToMany(\App\Models\Constant . pension::class, 'user_pensions', 'user_id', 'pension_id');
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

    public function roleUser() {
        return $this->hasMany(\App\Models\RoleUser::class);
    }

    public function roles() {
        return $this->hasManyThrough(\App\Models\Role::class, \App\Models\RoleUser::class, 'user_id', 'role_id');
    }

    public function usersSchools() {
        return $this->hasMany(\App\Models\UsersSchool::class);
    }

     public function tasks() {
        return $this->hasMany(\App\Models\Task::class);
    }
      public function role() {
        return $this->belongsTo('App\Models\Role')->withDefault(['display_name' => 'unknown']);
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id');
    }

    public function uattendance() {
        return $this->hasMany(\App\Models\Uattendance::class, 'user_id', 'id');
    }

    public function designation() {
        return $this->belongsTo(\App\Models\ReferDesignation::class,'designation_id','id')->withDefault(['display_name' => 'undefined']);
    }

}



