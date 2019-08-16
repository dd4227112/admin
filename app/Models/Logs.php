<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['url', 'user_agent', 'platform_name', 'source', 'user_id', 'country', 'city', 'region', 'isp', 'created_at', 'updated_at', 'platform', 'action', 'is_ajax', 'content', 'ip_address'];

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
