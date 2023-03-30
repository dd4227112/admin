<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DueAmountPayment extends Model
{
    use HasFactory;

      protected $table = 'due_amounts_payments';
    protected $fillable = ['id', 'payment_id', 'due_amount_id', 'amount'];


    public function payment() {
        return $this->belongsTo(\App\Models\Payment::class, 'payment_id', 'id');
    }

    public function dueAmount() {
        return $this->belongsTo(\App\Models\DueAmount::class, 'due_amount_id', 'id');
    }
}
