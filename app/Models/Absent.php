<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model {

  //  use \App\Traits\BelongsToUser;
  //  use \App\Traits\belongsTocompanyFile;


    /**
     * Generated
     */
    protected $table = 'admin.absents';
    protected $fillable = [
        'id', 'date', 'user_id', 'absent_reason_id', 'note', 'company_file_id', 'approved_by', 'created_at', 
        'updated_at','end_date'];


    public function absentReason() {
        return $this->belongsTo(\App\Models\AbsentReason::class, 'absent_reason_id', 'id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }


    public function approvedBy() {
        return $this->belongsTo(\App\Models\User::class)->withDefault(['name'=>'Not Approved']);
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id')->withDefault(['name' => 'unknown']);
    }

}
