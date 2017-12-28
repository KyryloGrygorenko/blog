@extends('layouts.master')

@section('content')

    <form method="post" action="/update" enctype="multipart/form-data">
        {{csrf_field()}}
        {{--{{ method_field('PATCH') }}--}}
        <div class="form-group" >
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}"  >
            <input type="hidden" id="postid" name="post_id" value="{{$post->id}}"  >

        </div>

        <h4>Chose image from our collection</h4>
        <hr>
        <div style="max-height: 300px; overflow: scroll" >
            @foreach ($all_images as $image)

                @if(file_exists(public_path() .'\img\\' .$image))
                    <input type = "image"  disabled value=""  src = "/img/{{$image}}" width="100px" height="65px"/>
                    <input type="radio" name="img" value="{{$image}}" >
                @endif

            @endforeach
        </div>

        <h3>Or just upload your own image</h3>
        <input type="file" name="image" >
        <div class="form-group">
            <label for="body">Body: (We don't have WYSIWYG available yet...)</label>
            <textarea name="body" id="body"  class="form-control" >{{$post->body}}</textarea>
        </div>

        <button type="submit" class="btn btn-success"> Save changes</button>
    </form>
    <br>
    <hr>
    @if ($is_user_author_of_post)
    <form method="post" action="/delete">
        {{csrf_field()}}
        <input type="hidden" id="delete_post" name="delete_post" value="true"  >
        <input type="hidden" id="postid" name="post_id" value="{{$post->id}}"  >
        <button type="submit" class="btn btn-danger">Delete this post</button>
    </form>
    @endif



<br>

            @include('layouts.errors')

@endsection