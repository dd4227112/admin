<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruimentQuiz extends Model {

    protected $table = 'recruiment_quiz';
    protected $fillable = ['id', 'name','description','created_at','updated_at'];
   
    public function recruimentquestions() {
        return $this->hasMany(\App\Models\RecruimentQuestions::class, 'quiz_id', 'id');
    }

  
}
