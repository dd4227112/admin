<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    public $timestamps = true;

    protected $table = 'admin.clients';

    protected $fillable = ['id', 'name', 'email', 'phone', 'address', 'lat', 'long', 'google_map', 'username',
    'status','code','email_verified','phone_verified','created_by','estimated_students','special_trial_code',
    'price_per_student','start_usage_date'];

    public function invoices() {
        return $this->hasMany(\App\Models\Invoice::class, 'client_id', 'id');
    }

    public function projects() {
        return $this->hasManyThrough(\App\Models\Project::class, \App\Models\ClientProject::class, 'project_id', 'client_id');
    }

    public function clientProjects() {
        return $this->hasMany(\App\Models\ClientProject::class, 'client_id', 'id');
    }

    public function payments() {
        return $this->hasMany(\App\Models\Payment::class, 'client_id', 'id');
    }
      public function createdBy() {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
   
    public function clientschool() { 
        return $this->hasMany(\App\Models\ClientSchool::class,'school_id', 'id');
    }

    public function standingorder() { 
        return $this->hasMany(\App\Models\StandingOrder::class,'client_id', 'id');
    }

     public function clientContract() { 
        return $this->hasMany(\App\Models\ClientContract::class,'contract_id', 'id');
    }

}