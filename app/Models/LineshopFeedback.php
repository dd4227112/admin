<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class LineshopFeedback extends Model {

    protected $table = 'admin.lineshop_feedback';
    public $timestamps = false;
    protected $fillable = [
        'feedback', 'username', 'schema','user_id','opened','table','shared'
    ];

    public function reply() {
        return $this->hasMany('\App\Models\LineshopFeedbackReply');
    }
    
    public function user() {
        return DB::table($this->attributes['schema'].$this->attributes['table'])->where($this->attributes['table'].'ID', $this->attributes['user_id'])->first();
    }
}
