<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancePayment extends Model
{
     use HasFactory;

     private $table = 'advance_payments';

      protected $fillable = ['id', 'client_id', 'payment_id', 'amount'];

      public function client() {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

      public function payment() {
        return $this->belongsTo(\App\Models\Payment::class, 'payment_id', 'id');
    }
}
