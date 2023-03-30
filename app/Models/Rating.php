<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {

    protected $table = 'admin.rating';
    protected $fillable = ['id', 'comment','user_table','user_id','usertype','module_id','rate','status','created_at','updated_at','schema_name'];

      public function modules() {
        return $this->belongsTo(\App\Models\Module::class, 'module_id', 'id');
    }
}
