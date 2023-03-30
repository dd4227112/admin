<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    /**
     * Generated
     */

    protected $table = 'setting';
    protected $primaryKey = 'settingID';
    protected $fillable = ['settingID', 'sname', 'name', 'phone', 'address', 'email', 'automation', 'currency_code', 'currency_symbol', 'footer', 'photo', 'username', 'password', 'usertype', 'api_key', 'api_secret', 'box', 'payment_integrated', 'pass_mark', 'website', 'motto', 'sms_enabled', 'email_enabled', 'sms_type', 'signature', 'signature_path', 'headname', 'exam_avg_format', 'school_format', 'registration_number', 'salary', 'id_number', 'show_zero_in_report', 'empty_mark', 'school_gender', 'institution_code', 'price_per_student', 'api_username', 'api_password', 'default_password', 'transaction_fee', 'nmb_comission', 'shulesoft_comission', 'bank_account_number', 'bank_name', 'show_report_to_all', 'show_report_to', 'custom_to', 'custom_to_amount', 'payment_status', 'payment_deadline_date', 'remember', 'email_list', 'currency_rounding', 'invoice_guide', 'transaction_charges_to_parents','other_learning_material'];

    // public function accountManager() {
    //     return $this->belongsTo(\App\Model\Admin::class,'account_manager_id','id');
    // }

}
