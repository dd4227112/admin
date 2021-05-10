<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruimentAnswers extends Model {

    protected $table = 'recruiment_answers';
    protected $fillable = ['id', 'recruiment_id','question_id','answer_id','created_at','updated_at'];

    public function recruiment() {
        return $this->belongsTo(\App\Models\Recruiment::class, 'recruiment_id', 'id');
    }

    public function question() {
        return $this->belongsTo(\App\Models\RecruimentQuestions::class, 'question_id', 'id');
    }

    public function answer() {
        return $this->belongsTo(\App\Models\QuizAnswers::class, 'answer_id', 'id');
    }

}
