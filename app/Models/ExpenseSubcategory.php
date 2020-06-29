<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseSubcategory extends Model {

    /**
     * Generated
     */
    protected $table = 'expense_subcategories';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];


    public function expenses() {
        return $this->hasMany(\App\Model\Expense::class);
    }

}
