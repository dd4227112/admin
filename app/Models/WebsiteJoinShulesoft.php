<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteJoinShulesoft extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'website_join_shulesoft';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['school_name', 'school_registration_number', 'school_address', 'school_id', 'students_number', 'message', 'contact_name', 'contact_phone', 'contact_email', 'created_at', 'updated_at', 'school_level'];

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
