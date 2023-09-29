<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacies extends Model
{
    use HasFactory;
    protected $table = 'admin.pharmacies';
    protected $fillable =['id', 'name','ownership', 'account_number' , 'created_at', 'updated_at', 'ward_id' , 'status', 'type', 'registered', 'ward', 'region', 'district' ];

    public function users() {
        return $this->hasManyThrough(\App\Models\UsersPharmacy::class,\App\Models\User::class);
    }
    
    public function wards() {
        return $this->belongsTo(\App\Models\Ward::class, 'ward_id', 'id')->withDefault(['name' => 'Not Defined']);
    }

    public function client() {
        return $this->belongsToMany(\App\Models\LineshopCLient::class, 'client_pharmacy', 'client_id', 'pharmacy_id');
    }

}
