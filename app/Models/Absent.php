<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model {

    /**
     * Generated
     */
    protected $table = 'absents';
    protected $fillable = [
        'id', 'date', 'user_id', 'absent_reason_id', 'note', 'company_file_id', 'approved_by', 'created_at', 'updated_at'
    ];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function absentReason() {
        return $this->belongsTo(\App\Models\AbsentReason::class);
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class);
    }

    public function approvedBy() {
        return $this->belongsTo(\App\Models\User::class)->withDefault(['name'=>'Not Approved']);
    }

}
