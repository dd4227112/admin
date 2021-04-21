<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyPerfomanceIndicator extends Model {


    protected $table = 'key_perfomance_indicators';
    protected $fillable = ['id', 'name', 'value', 'query','parameters'];

    public function keyparameters() {
        return $this->hasMany(\App\Models\QueryParameter::class, 'kpi_id', 'id');
    }
}
