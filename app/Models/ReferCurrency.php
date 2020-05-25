<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferCurrency extends Model {

    protected $table = 'constant.refer_currencies';
    protected $fillable = ['id', 'country_origin', 'currency', 'symbol', 'unit'];

    public function bankAccounts() {
        return $this->hasMany(\App\Models\BankAccount::class, 'refer_currency_id', 'id');
    }

}
