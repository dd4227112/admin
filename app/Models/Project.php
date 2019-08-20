<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    /**
     * Generated
     */
    protected $table = 'projects';
    protected $fillable = ['id', 'name'];

    public function invoiceFees() {
        return $this->hasMany(\App\Models\InvoiceFee::class, 'project_id', 'id');
    }

    public function clients() {
        return $this->hasMany(\App\Models\Client::class, 'client_id', 'id');
    }

}
