<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model {

    /**
     * Generated
     */

    protected $table = 'error_logs';
    protected $fillable = ['id', 'error_message', 'file', 'route', 'url', 'error_instance', 'request', 'schema_name', 'created_by', 'created_by_table'];



}
