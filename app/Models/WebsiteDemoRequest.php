<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteDemoRequest extends Model {

    /**
     * Generated
     */

    protected $table = 'website_demo_requests';
    protected $fillable = ['id', 'school_name', 'school_registration_number', 'school_location', 'school_id', 'message', 'contact_name', 'contact_phone', 'contact_email', 'school_level'];



}
