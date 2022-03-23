<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Task
 *
 * @author hp
 */
class ChatUser extends Model {

    use \App\Traits\BelongsToUser;

    
    //put your code here
    protected $table = 'chat_users';
    protected $fillable = ['id','message_id', 'user_id', 'to_user_id', 'created_at', 'updated_at'];

  

    public function message() {
        return $this->belongsTo(\App\Models\Chat::class, 'message_id', 'id');
    }

    public function toUser() {
        return $this->belongsTo(\App\Models\User::class, 'to_user_id', 'id');
    }

}
