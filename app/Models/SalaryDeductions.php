<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryDeductions extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'salary_deductions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'salary_id', 'deduction_id', 'amount', 'created_at', 'created_by'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

}
