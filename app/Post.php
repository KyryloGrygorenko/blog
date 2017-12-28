<?php

namespace App;
use App\Comment;
use Carbon\Carbon;

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function addComment($body)
    {
//        dd(auth()->id());
        Comment::create([
            'body' => $body,
            'post_id' => $this->id,
            'user_id' => auth()->id(),

        ]);

    }

    public function user() ////$post->user->name
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['month'])){
            if($month = $filters['month']){
                $query->whereMonth('created_at', Carbon::parse($month)->month);
            }
        }

        if(isset($filters['year'])){
            if($year = $filters['year']){
                $query->whereYear('created_at', $year);
            }
        }
    }

    public static function archives()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month,count(*) published')
            ->groupBy('year','month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toArray();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function unlikes()
    {
        return $this->hasMany(Unlike::class);
    }



//
//        if($month=$filters['month']){
//            $query->whereMonth('created_at', Carbon::parse($month)->month);
//        }
//        if($year=$filters['year']){
//            $query->whereYear('created_at',$year);
//        }
//
//    }


}
