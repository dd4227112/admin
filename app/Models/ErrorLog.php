<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ErrorLog extends Model {

    /**
     * Generated
     */
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table = 'error_logs';
    protected $fillable = ['id', 'error_message', 'file', 'route', 'url', 'error_instance', 'request', 'schema_name', 'created_by', 'created_by_table'];

}
