<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryPensions extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'salary_pensions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount', 'salary_id', 'pension_id', 'amount', 'created_at', 'created_by', 'employer_amount'];

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
