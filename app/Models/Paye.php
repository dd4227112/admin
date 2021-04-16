<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paye extends Model {

    /**
     * Generated
     */
    protected $table = 'constant.paye';
    protected $fillable = ['id', 'from', 'to', 'tax_rate', 'tax_plus_amount', 'name', 'description'];

}
