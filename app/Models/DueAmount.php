<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueAmount extends Model {

    /**
     * Generated
     */

    protected $table = 'due_amounts';
    protected $fillable = ['id', 'amount', 'client_id'];


    public function client() {
        return $this->belongsTo(\App\Models\Student::class, 'client_id', 'id');
    }

    public function payments() {
        return $this->belongsToMany(\App\Models\Payment::class, 'due_amounts_payments', 'due_amount_id', 'payment_id');
    }

    public function dueAmountsPayments() {
        return $this->hasMany(\App\Models\DueAmountsPayment::class, 'due_amount_id', 'id');
    }


}
