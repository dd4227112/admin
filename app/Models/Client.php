<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    /**
     * Generated
     */
    protected $table = 'clients';
    protected $fillable = ['id', 'name', 'email', 'phone', 'address', 'lat', 'long', 'google_map', 'username'];

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

}
