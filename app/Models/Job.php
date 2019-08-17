<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model {

    /**
     * Generated
     */

    protected $table = 'jobs';
    protected $fillable = ['id', 'queue', 'payload', 'attempts', 'reserved_at', 'available_at'];



}
