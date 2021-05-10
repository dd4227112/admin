<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruiment extends Model {

    protected $table = 'recruiments';
    
    protected $fillable = ['id', 'fullname','email','phone','country','dob','sex','location','marital_status',
     'education_level','field','year_of_graduation','skills','experience','jobtypes','source','career',
     'scope_of_operation','own_computer','about','company_file_id','created_at','updated_at'];

     public function quizanswers() {
        return $this->hasMany(\App\Models\RecruimentAnswers::class, 'recruiment_id', 'id');
    }
}
