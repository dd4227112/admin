<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSupportModule extends Model {

  
    protected $table = 'customer_support_modules';
    protected $fillable = ['id', 'module_id', 'low','medium','high','higher','created_at','updated_at'];

    public function module() {
        return $this->belongsTo(\App\Models\Module::class, 'module_id', 'id');
    }
}
