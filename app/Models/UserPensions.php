<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPensions extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_pensions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'table', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber', 'user_id', 'pension_id', 'created_at', 'updated_at', 'created_by', 'checknumber'];

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
