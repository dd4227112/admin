<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GlobalExam extends Model
{
    protected $table = 'constant.global_exams';
    
    public function association() {
        return $this->belongsTo('\App\Model\Association');
    }
}
