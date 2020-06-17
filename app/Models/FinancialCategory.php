<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialCategory extends Model {

    /**
     * Generated
     */
    protected $table = 'constant.financial_category';
    protected $fillable = ['id', 'name', 'create_date', 'financial_statement_id', 'note'];

    public function financialStatement() {
        return $this->belongsTo(\App\Model\FinancialStatement::class, 'financial_statement_id', 'id');
    }

    public function accountGroups() {
        return $this->hasMany(\App\Model\AccountGroup::class, 'financial_category_id', 'id');
    }

}
