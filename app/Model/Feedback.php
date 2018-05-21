<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model {

    protected $table = 'constant.feedback';
    public $timestamps = false;
    protected $fillable = [
        'feedback', 'username', 'schema','user_id','opened','table'
    ];

    public function reply() {
        return $this->hasMany('\App\Model\Feedback_reply');
    }
}
