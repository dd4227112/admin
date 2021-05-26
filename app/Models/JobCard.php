<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCard extends Model {

    /**
     * Generated
     */

    protected $table = 'job_cards';
    protected $fillable = ['id', 'module_id', 'client_id', 'user_id', 'date', 'created_at','updated_at'];

    public function module() {
        return $this->belongsTo(\App\Models\Module::class, 'module_id', 'id');
    }

    public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }


}
