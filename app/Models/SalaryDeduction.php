<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryDeduction extends Model {

    /**
     * Generated
     */

    protected $table = 'salary_deductions';
    protected $fillable = ['id', 'salary_id', 'deduction_id', 'amount', 'created_by'];


    public function salary() {
        return $this->belongsTo(\App\Models\Salary::class, 'salary_id', 'id');
    }

    public function deduction() {
        return $this->belongsTo(\App\Models\Deduction::class, 'deduction_id', 'id');
    }


}
