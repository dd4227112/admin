<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswers extends Model {

    protected $table = 'quiz_answers';
    protected $fillable = ['id', 'answer','created_at','updated_at'];
}
