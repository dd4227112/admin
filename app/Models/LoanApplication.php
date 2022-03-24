<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model {

    use \App\Traits\BelongsToUser;


    /**
     * Generated
     */
    protected $table = 'loan_applications';
    protected $fillable = ['id', 'user_id', 'table', 'created_by','approved_by','months','monthly_repayment_amount','loan_source_id','description', 'approval_status', 'amount', 'payment_start_date', 'loan_type_id', 'created_at', 'updated_at','qualify'];

    public function createdBy() {
        return \App\Models\User::where('id', $this->attributes['created_by'])->first();
    }

    public function approvedBy() {
        return \App\Models\User::where('id', $this->attributes['approved_by'])->first();
    }

    public function loanType() {
        return $this->belongsTo(\App\Models\LoanType::class, 'loan_type_id', 'id');
    }

}
