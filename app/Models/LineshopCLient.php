<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineshopCLient extends Model
{
    protected $table = 'admin.lineshop_clients';
    protected $fillable = [
        'id', 'name', 'email', 'phone', 'address', 'created_at', 'updated_at', 'lat', 'long', 'google_map', 'username', 'code', 'email_verified', 'phone_verified', 'created_by', 'special_trial_code', 'status', 'registration_number', 'region_id', 'ward_id', 'invoice_start_date',
        'invoice_end_date', 'start_usage_date', 'payment_option', 'owner_phone', 'owner_email', 'note', 'account_name', 'country_id', 'pharmacy_id', 'trial', 'warehouse_number', 'nature',
    ];
    // public function pharmacies() {
    //     return $this->belongsToMany(\App\Models\Pharmacies::class, 'client_pharmacy', 'pharmacy_id', 'client_id');
    // }

    // public function clientPharmacy() { 
    //     return $this->hasMany(\App\Models\ClientPharmacy::class,'pharmacy_id', 'id');
    // }

    public function clientPharmacy() {
        return $this->belongsTo(\App\Models\ClientPharmacy::class,   'id', 'client_id');
    }

}
