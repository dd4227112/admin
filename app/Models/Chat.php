<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class Chat extends Model {
    
    //put your code here
    protected $table = 'chats';
    protected $fillable = ['id','body', 'status', 'created_at', 'updated_at'];

    public function chatuser() {
        return $this->hasMany(\App\Models\ChatUser::class, 'message_id', 'id');
    }

}
