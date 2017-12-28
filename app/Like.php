<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Like extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function isset($user_id,$post_id)
    {
        $likes=DB::table('likes')->where('user_id', $user_id)
            ->where('post_id', $post_id)->first();

        return !is_null($likes);
    }

    public function is_users_like_first($user_id,$post_id)
    {
        $first_like=DB::table('likes')->where('post_id', $post_id)->where('like','1')->oldest()->first();

        if(is_object($first_like)){
            return $first_like->user_id == $user_id;
        };

        return false;
    }

    public function UpdateLike($user_id,$post_id)
    {
        DB::table('likes')
            ->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->update(['like' => 1]);

        DB::table('unlikes')
            ->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->update(['unlike' => 0]);
    }


}
