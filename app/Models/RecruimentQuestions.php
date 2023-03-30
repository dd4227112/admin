<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruimentQuestions extends Model {

    protected $table = 'recruiment_questions';
    protected $fillable = ['id', 'question','quiz_id','created_at','updated_at'];

    public function quiz() {
        return $this->belongsTo(\App\Models\RecruimentQuiz::class, 'quiz_id', 'id');
    }
}
