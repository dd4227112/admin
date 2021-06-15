<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPension extends Model {

    protected $table = 'salary_pensions';
    protected $fillable = ['id', 'salary_id', 'pension_id', 'amount', 'created_by', 'employer_amount'];

    public function salary() {
        return $this->belongsTo(\App\Models\Salary::class, 'salary_id', 'id');
    }

    public function pension() {
        return $this->belongsTo(\App\Models\Pension::class, 'pension_id', 'id');
    }


}
