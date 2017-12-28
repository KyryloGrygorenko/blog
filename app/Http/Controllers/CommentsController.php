<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([]);
    }

    public function store (Post $post)
    {
        $this->validate(request(),['body' => 'required|min:2|max:10000']);
        $post->addComment(request('body'));

        return back();

    }
}

