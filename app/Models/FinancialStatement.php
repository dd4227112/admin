<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FinancialStatement extends Model {

    /**
     * Generated
     */

      protected $table = 'constant.financial_statement';
    protected $fillable = ['name', 'create_date', 'id', 'note'];


    public function financialCategories() {
        return $this->hasMany(\App\Model\FinancialCategory::class, 'financial_statement_id', 'id');
    }


}
