<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    /**
     * Generated
     */

    protected $table = 'clients';
    protected $fillable = ['id', 'name', 'email', 'phone', 'address', 'lat', 'long', 'google_map'];


    public function invoices() {
        return $this->hasMany(\App\Models\Invoice::class, 'client_id', 'id');
    }


}
