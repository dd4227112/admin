<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteJoinShulesoft extends Model {

    protected $table = 'admin.website_join_shulesoft';
    protected $fillable = ['id', 'school_name', 'school_registration_number', 'school_address', 'school_id', 'students_number', 'message', 'contact_name', 'contact_phone', 'contact_email', 'school_level'];


    public function school(){
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id')->withDefault(['name' => 'Unknown']);
    }
}
