<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffTarget extends Model {

    /**
     * Generated
     */
    public $table = 'shulesoft.staff_targets';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'kpi', 'user_sid', 'value', 'start_date', 'end_date', 'is_derived', 'is_derived_sql', 'created_by_sid', 'schema_name', 'connection'];

    public function createdBy() {
        return $this->belongsTo(\App\Models\Shulesoftuser::class, 'created_by_sid', 'sid');
    }

    public function user() {
        return $this->belongsTo(\App\Models\Shulesoftuser::class, 'user_sid', 'sid');
    }

    public function staffTargetsReports() {
        return $this->hasMany(\App\Models\StaffTargetsReport::class);
    }

}
