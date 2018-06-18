<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Feedback extends Model {

    protected $table = 'constant.feedback';
    public $timestamps = false;
    protected $fillable = [
        'feedback', 'username', 'schema','user_id','opened','table'
    ];

    public function reply() {
        return $this->hasMany('\App\Model\Feedback_reply');
    }
    
    public function user() {
        return DB::table($this->attributes['schema'].$this->attributes['table'])->where($this->attributes['table'].'ID', $this->attributes['user_id'])->first();
    }
}
