<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCart extends Model {

    /**
     * Generated
     */
    protected $table = 'product_cart';
    protected $fillable = ['id', 'product_alert_id','quantity','amount', 'name','revenue_id'];
  
    public function revenues() { 
        return $this->belongsTo(\App\Models\Revenue::class, 'revenue_id', 'id');
    }

    public function productQuantity() { 
        return $this->belongsTo(\App\Models\ProductQuantity::class, 'product_alert_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

}
