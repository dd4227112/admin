<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryParameter extends Model {

    protected $table = 'query_parameters';
    protected $fillable = ['id', 'kpi_id','parameter', 'created_at','updated_at'];

    public function kpi() {
        return $this->belongsTo(\App\Models\KeyPerfomanceIndicator::class, 'kpi_id', 'id');
    }

}