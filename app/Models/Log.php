<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {

    /**
     * Generated
     */

    protected $table = 'log';
    protected $fillable = ['id', 'url', 'user_agent', 'platform_name', 'source', 'user_id', 'country', 'city', 'region', 'isp', 'platform', 'action', 'is_ajax', 'content', 'ip_address'];
}
