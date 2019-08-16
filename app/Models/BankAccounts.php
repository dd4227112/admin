<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccounts extends Model  
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bank_accounts';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'number', 'currency', 'branch', 'note', 'created_at', 'account_name', 'feetype_id', 'refer_currency_id', 'refer_bank_id', 'opening_balance', 'updated_at', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'name', 'number', 'currency', 'branch', 'refer_bank_id', 'opening_balance', 'note', 'created_at', 'updated_at', 'refer_currency_id', 'number', 'branch', 'note', 'account_name', 'refer_currency_id', 'refer_bank_id', 'opening_balance', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

}
