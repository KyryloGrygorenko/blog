<?php

namespace App;


class Comment extends Model
{
    public function post()//$comment->post->body  KG
    {
//        dump($this->belongsTo(Post::class));
//        exit();
        return $this->belongsTo(Post::class);

    }
    public function user() //$comment->user->name
    {
        return $this->belongsTo(User::class);
    }
}
