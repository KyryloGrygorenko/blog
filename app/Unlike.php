<?php

namespace App;
use Illuminate\Support\Facades\DB;

class Unlike extends Model
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
        $unlikes=DB::table('unlikes')->where('user_id', $user_id)
            ->where('post_id', $post_id)->first();

        return !is_null($unlikes);
    }

    public function UpdateUnlike($user_id,$post_id)
    {
        DB::table('unlikes')
            ->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->update(['unlike' => 1]);

        DB::table('likes')
            ->where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->update(['like' => 0]);
    }
}
