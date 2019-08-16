<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pensions extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pensions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at', 'name', 'employer_percentage', 'employee_percentage', 'created_at', 'address', 'updated_at'];

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
