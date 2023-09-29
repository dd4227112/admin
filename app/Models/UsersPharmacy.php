<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersPharmacy extends Model {
  
    //use \App\Traits\BelongsToUser;

    /**
     * Generated
     */
    protected $table = 'users_pharmacies';
    protected $fillable = ['id', 'user_id', 'pharmacy_id','client_id','role_id', 'status', 'created_at', 'updated_at'];

    public function Pharmacy() {
        return $this->belongsTo(\App\Models\Pharmacies::class, 'pharmacy_id', 'id');
    }


    public function role() {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

}
