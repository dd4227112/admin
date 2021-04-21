<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model {

    /**
     * Generated
     */
    protected $table = 'loan_types';
    protected $fillable = ['id', 'name', 'source', 'minimum_amount', 'maximum_amount', 'maximum_tenor', 'minimum_tenor', 'interest_rate', 'credit_ratio', 'created_by', 'created_at', 'updated_at','description'];

    public function createdBy() {
        return \App\Models\User::where('id', $this->attributes['created_by'])->first();
    }

}
