<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model {

    /**
     * Generated
     */
    protected $table = 'loan_applications';
    protected $fillable = ['id', 'user_id', 'table', 'created_by', 'created_by_table', 'approved_by','months','monthly_repayment_amount','loan_source_id', 'approved_by_table','description', 'approval_status', 'amount', 'payment_start_date', 'loan_type_id', 'created_at', 'updated_ad','qualify'];

    public function createdBy() {
        return \App\Model\User::where('table', $this->attributes['created_by_table'])->where('id', $this->attributes['created_by'])->first();
    }

    public function approvedBy() {
        return \App\Model\User::where('table', $this->attributes['approved_by'])->where('id', $this->attributes['approved_by_table'])->first();
    }

    public function user() {
        return \App\Model\User::where('table', $this->attributes['table'])->where('id', $this->attributes['user_id'])->first();
    }

    public function loanType() {
        return $this->belongsTo(\App\Model\LoanType::class, 'loan_type_id', 'id');
    }

}
