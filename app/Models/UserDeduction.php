<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeduction extends Model {

    /**
     * Generated
     */

    protected $table = 'user_deductions';
    protected $fillable = ['id', 'user_id', 'deduction_id', 'created_by', 'deadline', 'type', 'amount', 'percent', 'index_number','loan_application_id'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function deduction() {
        return $this->belongsTo(\App\Models\Deduction::class, 'deduction_id', 'id');
    }

    public function loanApplication() {
        return $this->belongsTo(\App\Models\LoanApplication::class, 'loan_application_id', 'id');
    }

}
