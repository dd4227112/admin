<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GlobalExam extends Model
{
    protected $table = 'constant.global_exams';
    
      protected $fillable = ['id', 'name', 'global_exam_definition_id','date', 'school_level_id'];

    public function globalExamDefinition() {
        return $this->belongsTo('\App\Model\GlobalExamDefinition');
    }
}
