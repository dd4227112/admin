<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model {

    /**
     * Generated
     */
    protected $table = 'admin.absents';
    protected $fillable = [
        'id', 'date', 'user_id', 'absent_reason_id', 'note', 'company_file_id', 'approved_by', 'created_at', 
        'updated_at','end_date'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class,'user_id','id');
    }

    public function absentReason() {
        return $this->belongsTo(\App\Models\AbsentReason::class, 'absent_reason_id', 'id');
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class);
    }

    public function approvedBy() {
        return $this->belongsTo(\App\Models\User::class)->withDefault(['name'=>'Not Approved']);
    }

}
