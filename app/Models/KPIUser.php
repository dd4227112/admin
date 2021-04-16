<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KPIUser extends Model {

    /**
     * Generated
     */

    protected $table = 'kpi_users';
    protected $fillable = ['id', 'kpi_id','user_id', 'created_at','updated_at'];

    public function kpi() {
        return $this->belongsTo(\App\Models\KeyPerfomanceIndicator::class, 'kpi_id', 'id');
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

}