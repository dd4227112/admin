<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPharmacy extends Model {

    protected $table = 'admin.client_pharmacy';
    protected $fillable = ['id', 'client_id', 'pharmacy_id', 'created_at', 'updated_at'];

    public function pharmacies() {
        return $this->hasMany(\App\Models\Pharmacies::class, 'pharmacy_id', 'id')->withDefault(['name'=>'Not Defined']);
    }

    public function client() {
        return $this->hasMany(\App\Models\LineshopCLient::class, 'client_id', 'id')->withDefault(['name'=>'Not Defined']);
    }

}
