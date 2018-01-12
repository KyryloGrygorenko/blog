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
use Illuminate\Support\Facades\Input;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'update']);
    }


    public function index()
    {

        $unfiltered_posts = Post::latest()
            ->filter(request(['month', 'year']))
            ->get();


        if(isset($unfiltered_posts[0]))
        {
            $posts=$this->filter_posts($unfiltered_posts);

            return view('posts.index', compact('posts', 'archives'));

        };

        $posts = [];
        return view('posts.index', compact('posts', 'archives'));
    }


    public function show_all_users_posts (User $user)
    {
        $unfiltered_posts = Post::latest()
            ->where('user_id', $user['id'])
            ->filter(request(['month', 'year']))
            ->get();

        if(isset($unfiltered_posts[0]))
        {
            $posts=$this->filter_posts($unfiltered_posts);

            return view('posts.index', compact('posts', 'archives'));

        };

        $posts = [];

        return view('posts.index', compact('posts', 'archives'));
    }


    public function show(Post $post)
    {
        $user_can_edit_post=$this->is_user_allowed_to_edit_post($post);

        $post->body=$this->words_filter($post->body);
        $post->title=$this->words_filter($post->title);

        return view('posts.show', compact('post','user_can_edit_post'));
    }

    public function edit(Post $post)
    {
        $is_user_author_of_post=$this->is_user_author_of_post($post);

        if ( $is_user_author_of_post || $this->is_user_allowed_to_edit_post($post)) {
            $img_dir=public_path();
            $img_dir.='/img/';

            $all_images = [];
            foreach (scandir($img_dir) as $key => $value) {
                if ($value !== '.' && $value !== '..') {
                    $findme1 = '.jpeg';
                    $findme2 = '.jpg';
                    $findme3 = '.png';
                    if (stripos($value, $findme1) || stripos($value, $findme2) || stripos($value, $findme3)) {
                        $all_images [] = $value;
                    }

                }
            }

            $post->body=$this->words_filter($post->body);
            $post->title=$this->words_filter($post->title);

            return view('posts.edit', compact(['post','all_images','is_user_author_of_post']));
        }

        return back();

    }

    public function update()
    {
        $post = Post::find(request('post_id'));

        $post->body = request('body');
        $post->title = request('title');

        if(Input::file('image')){
            $image=Input::file('image');
            $image->move(public_path() . '/img/', $image->getClientOriginalName());
            $post->img = $image->getClientOriginalName();
        }else{
            $post->img = request('image');
        }
            $post->save();


        return redirect('/posts/' . request('post_id'));
    }

    public function delete()
    {

        if (request('delete_post'))
        {
            $post = Post::find(request('post_id'));
            $post->delete();
        }


        return redirect('/');
    }


    public function create()
    {

        $img_dir=public_path();
        $img_dir.='/img/';

        $all_images = [];
        foreach (scandir($img_dir) as $key => $value) {
            if ($value !== '.' && $value !== '..') {
                $findme1 = '.jpeg';
                $findme2 = '.jpg';
                $findme3 = '.png';
                if (stripos($value, $findme1) || stripos($value, $findme2) || stripos($value, $findme3)) {
                    $all_images [] = $value;
                }

            }
        }

        return view('posts.create',compact('all_images'));
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'required'
        ]);

        if($image=Input::file('image'))
        {
            $image->move(public_path() . '/img/', $image->getClientOriginalName());
            $image=$image->getClientOriginalName();
        }else{
            $image=request('image');
        }

        auth()->user()->publish(
            new Post([
                'title'=>request('title'),
                'body'=>request('body'),
                'img'=>$image
            ])
        );
        session()->flash('message','Your post has now been published!');
        return redirect('/');

    }

    public function words_filter($string)
    {
        $filter = new Filter;

        if($filter->getFilterWords()){
            $filter = $filter->getFilterWords();
            $patterns = trim($filter->body," ");
            $patterns=explode(',',$patterns);

            foreach ($patterns as $pattern){
                $pattern=trim($pattern," ");
                $patterns_corrected[]="/" . $pattern . "/";
            }

            foreach ($patterns_corrected as $pattern){
                $pattern=trim($pattern,"/");
                $replacing='';
                for ( $i = 1; $i < mb_strlen($pattern) - 1; $i++ ){
                    $replacing .= '*';
                }
                $replacements[]=mb_substr($pattern,0,1) . $replacing . mb_substr($pattern,mb_strlen($pattern)-1,mb_strlen($pattern)) ;
            }

            ksort($patterns_corrected);
            ksort($replacements);

            return preg_replace($patterns_corrected, $replacements, $string) ;
        }

        return $string ;
    }


    public function show_words_filter()
    {
        $filter = new Filter;
        $filter = $filter->getFilterWords();

        return view('posts.show_words_filter', compact('filter'));
    }


    public function store_words_filter()
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $filter = new Filter;
        $filter->body = request('body');
        $filter->id = 1;
        $filter->save();

        return redirect('/show_words_filter');
    }


    public function update_words_filter()
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $filter = new Filter;
        $filter = $filter->setFilterWords(request('body'));

        return redirect('/show_words_filter');
    }


    public function filter_posts($unfiltered_posts)
    {
        foreach ($unfiltered_posts as $post){
            $post->body=$this->words_filter($post->body);
            $post->title=$this->words_filter($post->title);
            $posts[]=$post;
        }

        return $posts;
    }


    public function is_user_allowed_to_edit_post(Post $post)
    {
        $user_can_edit_post=false;

        if(is_object(auth::user()))
        {
            $user_id=auth::user()->id;
            $post_id=$post->id;

            $post->body=$this->words_filter($post->body);
            $post->title=$this->words_filter($post->title);
            $like= new Like;
            if($like->is_users_like_first($user_id,$post_id))
            {
                $user_can_edit_post=true;
            };

        };

        return $user_can_edit_post;
    }


    public function is_user_author_of_post(Post $post)
    {
        return $post->user_id == auth()->user()->id;
    }


}
