<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolKeys extends Model {

    /**
     * Generated
     */
    protected $table = 'school_keys';
    protected $fillable = ['id', 'schema_name', 'api_key', 'last_active', 'created_at', 'updated_at'];

   

}
