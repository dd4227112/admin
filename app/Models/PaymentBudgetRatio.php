<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentBudgetRatio extends Model {

    /**
     * Generated
     */
    protected $table = 'payments_budget_ratios';
    protected $fillable = ['id', 'budget_ratio_id', 'payment_id', 'amount'];

    public function budgetRatio() {
        return $this->belongsTo(\App\Models\BudgetRatio::class);
    }

    public function payment() {
        return $this->belongsTo(\App\Models\Payment::class);
    }

}
