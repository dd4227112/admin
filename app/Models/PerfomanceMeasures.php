<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfomanceMeasures extends Model {

    protected $table = 'perfomance_meaures';

    protected $fillable = ['id', 'date', 'user_id', 'school_id','module','created_at','updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function school() {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id');
    }

}