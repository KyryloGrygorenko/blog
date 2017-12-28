@extends('layouts.master')

@section('content')
    <div class="col-sm-10 blog-main">

    <h1>{{$post->title}}</h1>

        <br>

        @if (file_exists(public_path() .'\img\\' .$post->img))
            <img src="\img\{{$post->img}} "  width="100%" height="100%">
        @endif

    </div>

    {{$post->body}}


    <div class="row">
        @if(Auth::user() && Auth::user()->id == $post->user_id )
            <br>
            <a href="/posts/edit/{{$post->id}}"><button type="button" class="btn btn-primary">Edit this post </button></a>
        @else
            @if ($user_can_edit_post)
            <br>
            <a href="/posts/edit/{{$post->id}}"><button type="button" class="btn btn-primary">You can edit this post as you liked it first!!! </button></a>
            @endif
        @endif
        <br>
        <form method="post" action="/like">
            {{csrf_field()}}
            <input type="hidden" id="like" name="like" value="1">
            <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}">
            <button  type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-thumbs-o-up" aria-hidden="true"> {{$post->likes->sum('like')}}</i>
            </button>

        </form>

        <form method="post" action="/unlike">
            {{csrf_field()}}
            <input type="hidden" id="unlike" name="like" value="1">
            <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}">
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa fa-thumbs-o-down" aria-hidden="true"> {{$post->unlikes->sum('unlike')}}</i>
            </button>
        </form>
    </div>

    <div class="comments">
        @foreach($post->comments as $comment)


            <br>

            <li class="list-group-item">
                <strong>
            {{$comment->created_at->diffForHumans()}} &nbsp;by {{$comment->user->name}} :
                </strong>
            {{$comment->body}}

            </li>
            <br>


        @endforeach
    </div>




    <hr>

    <div class="card">
        <div class="card-block">
            <form method="POST" action="/posts/{{ $post->id }}/comments">

                {{ csrf_field() }}

                <div class="form-group">
                    <textarea name="body" placeholder="Your comment here." class="form-control" required >  </textarea>
                </div>

                <div class="form-group">
                   <button type="submit" class="btn btn-primary">Add comment</button>
                </div>


            </form>
            @include('layouts.errors')
        </div>
    </div>
@endsection