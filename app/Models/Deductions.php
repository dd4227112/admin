<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deductions extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'deductions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'created_at', 'updated_at', 'description', 'is_percentage', 'category', 'name', 'percent', 'amount', 'description', 'is_percentage', 'category', 'bank_account_id', 'account_number', 'created_at', 'updated_at'];

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
