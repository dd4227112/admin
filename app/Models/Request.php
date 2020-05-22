<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model {

    /**
     * Generated
     */

    protected $table = 'request';
    protected $fillable = ['request_id', 'from_name', 'email', 'phone_number', 'location', 'website', 'user_type', 'status', 'staff_allocated', 'message', 'reg_date', 'school', 'demo_request_date', 'type', 'user_agent'];



}
