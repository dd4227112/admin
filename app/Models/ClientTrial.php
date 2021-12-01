<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTrial extends Model {

    protected $table = 'admin.client_trials';
    protected $fillable = ['id', 'client_id', 'period', 'start_date','end_date','created_at','status'];

 
    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

}
