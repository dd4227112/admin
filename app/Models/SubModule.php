<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubModule extends Model {

    /**
     * Generated
     */

    protected $table = 'sub_modules';
    protected $fillable = ['id', 'name', 'module_id', 'created_at'];


    public function module() {
        return $this->belongsTo(\App\Models\Module::class, 'module_id', 'id');
    }

}
