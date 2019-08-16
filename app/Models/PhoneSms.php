<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneSms extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'phone_sms';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['address', 'date', 'type', 'body', 'slot', 'name', 'published'];

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
