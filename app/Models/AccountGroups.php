<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountGroups extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'account_groups';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'category_id', 'financial_category_id', 'name', 'created_at', 'updated_at', 'note', 'financial_category_id'];

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
