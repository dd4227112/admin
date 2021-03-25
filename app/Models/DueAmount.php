<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueAmount extends Model {

    /**
     * Generated
     */

    protected $table = 'due_amounts';
    protected $fillable = ['id', 'amount', 'student_id'];


    public function fee() {
        return $this->belongsTo(\App\Models\Fee::class, 'fee_id', 'id');
    }

    public function student() {
        return $this->belongsTo(\App\Models\Student::class, 'student_id', 'student_id');
    }

    public function payments() {
        return $this->belongsToMany(\App\Model\Payment::class, 'due_amounts_payments', 'due_amount_id', 'payment_id');
    }

    public function dueAmountsPayments() {
        return $this->hasMany(\App\Model\DueAmountsPayment::class, 'due_amount_id', 'id');
    }


}
