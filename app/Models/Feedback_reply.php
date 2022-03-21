<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback_reply extends Model {

    protected $table = 'constant.feedback_reply';
    public $timestamps = false;
    protected $fillable = [
        'feedback_id', 'message', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('\App\Model\User');
    }
}
