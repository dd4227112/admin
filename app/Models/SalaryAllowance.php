<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryAllowance extends Model {

    /**
     * Generated
     */

    protected $table = 'salary_allowances';
    protected $fillable = ['id', 'salary_id', 'allowance_id', 'amount', 'created_by'];


    public function salary() {
        return $this->belongsTo(\App\Models\Salary::class, 'salary_id', 'id');
    }

    public function allowance() {
        return $this->belongsTo(\App\Models\Allowance::class, 'allowance_id', 'id');
    }


}
