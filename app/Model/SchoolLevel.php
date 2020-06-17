<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SchoolLevel extends Model {

    protected $table = 'constant.school_levels';
    protected $fillable = ['id', 'name', 'level_numeric', 'refer_country_id', 'syllabus', 'span_number', 'result_format', 'note', 'updated_at', 'created_at'];

}
