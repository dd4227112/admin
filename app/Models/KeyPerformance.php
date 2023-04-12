<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyPerformance extends Model {

    /**
     * Generated
     */
    public $table = 'admin.key_performances';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['name', 'created_by', 'custom_query', 'sid'];



}
