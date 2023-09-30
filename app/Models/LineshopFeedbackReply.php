<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineshopFeedbackReply extends Model {

    // use \App\Traits\BelongsToUser;


    protected $table = 'admin.lineshop_feedback_reply';
    public $timestamps = false;
    protected $fillable = [
        'feedback_id', 'message', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id')->withDefault(['name' => 'Unknown']);
    }

 
}
