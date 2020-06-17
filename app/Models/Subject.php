<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {

    /**
     * Generated
     */
    protected $table = 'subjects';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name', 'class_id', 'created_at', 'updated_at'];

    public function referClass() {
        return $this->belongsTo(\App\Models\ReferClasses::class, 'class_id', 'id');
    }

}
