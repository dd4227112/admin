<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

    protected $table = 'modules';
    protected $fillable = ['id', 'name', 'created_at'];

       public function ratings() {
        return $this->hasMany(\App\Models\Rating::class, 'module_id', 'id');
    }
}
