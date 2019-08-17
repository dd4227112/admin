<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountGroup extends Model {

    /**
     * Generated
     */

    protected $table = 'account_groups';
    protected $fillable = ['id', 'name', 'note', 'financial_category_id'];


    public function constant.financialCategory() {
        return $this->belongsTo(\App\Models\Constant.financialCategory::class, 'financial_category_id', 'id');
    }

    public function referExpenses() {
        return $this->hasMany(\App\Models\ReferExpense::class, 'financial_category_id', 'id');
    }


}
