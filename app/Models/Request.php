<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['request_id', 'from_name', 'email', 'phone_number', 'location', 'website', 'user_type', 'status', 'staff_allocated', 'message', 'reg_date', 'school', 'demo_request_date', 'type', 'user_agent'];

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
