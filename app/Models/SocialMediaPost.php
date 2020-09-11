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
class SocialMediaPost extends Model {
   
    //put your code here
    protected $table = 'socialmedia_post';
    protected $fillable = ['id', 'likes', 'comments', 'views', 'share', 'reach', 'post_id', 'socialmedia_id', 'created_at', 'updated_at'];

    public function post() {
        return $this->belongsTo(\App\Models\MediaPost::class, 'post_id', 'id');
    }

    public function media() {
        return $this->belongsTo(\App\Models\SocialMedia::class, 'socialmedia_id', 'id');
    }

}
