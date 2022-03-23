<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of TaskComment
 *
 * @author hp
 */
class MediaPost extends Model {

    use \App\Traits\BelongsToUser;


    //put your code here
    protected $table = 'mediapost';
    protected $fillable = ['id', 'note', 'title', 'category', 'user_id', 'type', 'created_at', 'updated_at'];


    public function medias() {
        return $this->hasMany(\App\Models\SocialMediaPost::class, 'post_id', 'id');
    }

}
