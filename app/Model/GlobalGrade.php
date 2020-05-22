<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GlobalGrade extends Model
{
     protected $table = 'constant.global_grades';
     
       protected $fillable = ['id', 'grade', 'point', 'gradefrom', 'gradeupto', 'note', 'classlevel_id'];

}
