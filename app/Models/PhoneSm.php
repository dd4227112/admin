<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneSm extends Model {

    /**
     * Generated
     */

    protected $table = 'phone_sms';
    protected $fillable = ['address', 'date', 'type', 'body', 'slot', 'name', 'published'];



}
