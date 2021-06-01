<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learning extends Model {

    /**
     * Generated
     */

    protected $table = 'learnings';
    protected $fillable = ['id', 'course_name','from_date','to_date','source','has_certificate',
                           'company_file_id','user_id','descriptions','course_link','created_at','updated_at'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function companyFile() {
        return $this->belongsTo(\App\Models\CompanyFile::class, 'company_file_id', 'id');
    }


}