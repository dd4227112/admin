<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneCall extends Model {

    /**
     * Generated
     */

    protected $table = 'phone_calls';
    protected $fillable = ['full_name', 'call_detail', 'email', 'phone_number','call_type','call_time','next_followup','call_duration','user_id','location','created_at','updated_at','followup_date'];





}