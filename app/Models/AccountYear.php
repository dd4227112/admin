<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountYear extends Model {

    /**
     * Generated
     */
    protected $table = 'account_years';
    protected $fillable = ['id', 'name', 'status', 'start_date', 'end_date'];


    public function invoices() {
        return $this->hasMany(\App\Model\Invoice::class);
    }

}
