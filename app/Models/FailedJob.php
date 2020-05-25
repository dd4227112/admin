<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model {

    /**
     * Generated
     */

    protected $table = 'failed_jobs';
    protected $fillable = ['id', 'connection', 'queue', 'payload', 'exception', 'failed_at'];



}
