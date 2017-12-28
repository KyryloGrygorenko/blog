<?php

namespace App\Repositories;

use App\Post;

class Posts
{
    public function all()
    {
        //retur all posts
        return Post::all();
    }

    public  function find()
    {

    }
}