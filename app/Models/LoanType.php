<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model {

    /**
     * Generated
     */
    protected $table = 'loan_types';
    protected $fillable = ['id', 'name', 'source', 'minimum_amount', 'maximum_amount', 'maximum_tenor', 'minimum_tenor', 'interest_rate', 'credit_ratio', 'created_by', 'created_by_table', 'created_at', 'updated_at','description'];

    public function createdBy() {
        return \App\Model\User::where('table', $this->attributes['created_by_table'])->where('id', $this->attributes['created_by'])->first();
    }

}
