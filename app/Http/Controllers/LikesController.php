<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Filter;
use App\Like;
use App\Unlike;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'update']);
    }

    public function like()
    {
        $like=new Like;
        $unlike=new Unlike;
        $user_id=auth::user()->id;
        $post_id=request('post_id');

        if($like->isset($user_id,$post_id)){
            $like->UpdateLike($user_id,$post_id);
        }else{
            $like->like = 1;
            $like->user_id = $user_id;
            $like->post_id = $post_id;
            $like->save();

            $unlike->unlike = 0;
            $unlike->user_id = $user_id;
            $unlike->post_id = $post_id;
            $unlike->save();
        }

        return redirect('/posts/' .request('post_id'));
    }


    public function unlike()
    {
        $unlike=new Unlike;
        $like=new Like;
        $user_id=auth::user()->id;
        $post_id=request('post_id');

        if($unlike->isset($user_id,$post_id)){
            $unlike->UpdateUnlike($user_id,$post_id);
        }else{
            $unlike->unlike = 1;
            $unlike->user_id = $user_id;
            $unlike->post_id = $post_id;
            $unlike->save();

            $like->like = 0;
            $like->user_id = $user_id;
            $like->post_id = $post_id;
            $like->save();
        }

        return redirect('/posts/' .request('post_id'));
    }


}
