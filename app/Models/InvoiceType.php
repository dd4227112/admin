<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceType extends Model {

    /**
     * Generated
     */

    protected $table = 'invoice_types';
    protected $fillable = ['id', 'name','created_at','updated_at'];



}