<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolAgreement extends Model {

    protected $table = 'admin.school_agreement';
    protected $fillable = ['id', 'school_id', 'form_type', 'contact_person_name', 'contact_person_phone',
                          'contact_person_designation','company_file_id', 'agreement_date','created_by','created_at', 'updated_at'];

    public function school() {
        return $this->belongsTo(\App\Models\School::class,'school_id','id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id')->withDefault(['name' => 'Unknown']);
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id')->withDefault(['name' => 'unknown']);
    }

}
