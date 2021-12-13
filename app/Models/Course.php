<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

    /**
     * Generated
     */

    protected $table = 'admin.courses';
    protected $fillable = ['id', 'course_name','from_date','to_date','source','has_certificate',
                           'company_file_id','created_by','descriptions','course_link','created_at','updated_at'];

    public function createdBy() {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id');
    }


}