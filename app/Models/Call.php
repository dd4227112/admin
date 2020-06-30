<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model {

    /**
     * Generated
     */

    protected $table = 'calls';
    protected $fillable = ['id', 'name', 'number', 'type', 'time', 'duration'];



}
