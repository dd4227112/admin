<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffTargetsReport extends Model {

    /**
     * Generated
     */
    public $table = 'shulesoft.staff_targets_reports';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'staff_report_id', 'staff_target_id', 'date', 'current_value', 'is_approved', 'schema_name'];

    public function staffReport() {
        return $this->belongsTo(\App\Models\StaffReport::class, 'staff_report_id', 'id');
    }

    public function staffTarget() {
        return $this->belongsTo(\App\Models\StaffTarget::class, 'staff_target_id', 'id');
    }

}
