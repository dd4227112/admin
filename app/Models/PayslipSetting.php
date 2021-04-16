<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayslipSetting extends Model {

    /**
     * Generated
     */

    protected $table = 'payslip_settings';
    protected $fillable = ['id', 'show_employee_signature', 'show_employer_signature', 'show_employee_digital_signature', 
                            'show_employer_digital_signature','show_address','show_tax_summary','show_employer_contribution'];



}
