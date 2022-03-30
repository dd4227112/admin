<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuidePageVisit extends Model {

    protected $table = 'constant.guide_page_visits';
    protected $fillable = [
        'guide_id', 'user_id', 'schema', 'user_table', 'page_rate', 'page_comment'
    ];

}
