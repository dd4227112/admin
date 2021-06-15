<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pension extends Model {

    /**
     * Generated
     */

    protected $table = 'pensions';
    protected $fillable = ['id', 'name', 'employer_percentage', 'employee_percentage', 'address'];


    public function salaries() {
        return $this->belongsToMany(\App\Models\Salary::class, 'salary_pensions', 'pension_id', 'salary_id');
    }

    public function salaryPensions() {
        return $this->hasMany(\App\Models\SalaryPension::class, 'pension_id', 'id');
    }


    public function userPensions(){
        return $this->hasMany(\App\Models\UserPension::class, 'pension_id', 'id');

    }


}
