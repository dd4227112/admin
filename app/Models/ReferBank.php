<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferBank extends Model {

    /**
     * Generated
     */

    protected $table = 'constant.refer_banks';
    protected $fillable = ['id', 'name', 'address', 'location', 'refer_country_id','swiftcode'];


    public function bankAccounts() {
        return $this->hasMany(\App\Models\BankAccount::class, 'refer_bank_id', 'id');
    }


}
