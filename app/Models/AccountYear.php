<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountYear extends Model {

    /**
     * Generated
     */
    protected $table = 'account_years';
    protected $fillable = ['id', 'name', 'status', 'start_date', 'end_date'];


    public function invoices() {
        return $this->hasMany(\App\Model\Invoice::class, 'academic_year_id', 'id');
    }



    public function installments() {
        return $this->hasMany(\App\Model\Installment::class, 'academic_year_id', 'id');
    }


    public function reminderTemplates() {
        return $this->hasMany(\App\Model\ReminderTemplate::class, 'academic_year_id', 'id');
    }

    public function students() {
        return $this->hasMany(\App\Model\Student::class, 'academic_year_id', 'id');
    }

    public static function getCurrentYear($class_level_id) {
        return $this->db->query('select * FROM ' . set_schema_name() . 'academic_year WHERE class_level_id=' . $class_level_id . ' ORDER BY  end_date DESC LIMIT 1')->row();
    }

}
