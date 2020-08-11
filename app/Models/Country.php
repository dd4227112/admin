<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    /**
     * Generated
     */

    protected $table = 'constant.refer_countries';
    protected $fillable = ['id', 'dialling_code', 'country_code', 'country'];

}
