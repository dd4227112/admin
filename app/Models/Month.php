<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Month extends Model {

    /**
     * Generated
     */
    protected $table = 'constant.months';

    protected $fillable = ['id', 'month_name'];
    
   
}
