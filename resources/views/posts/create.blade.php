@extends('layouts.master')

@section('content')
    <h1>Create a post</h1>
    <hr>


    <form method="POST" action="/posts" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group" >

        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title"  >
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

        <h3> Or just upload your own image</h3>
        <input type="file" name="image" >




        <br><br><br>
        <div class="form-group">
            <label for="body">Body: (We don't have WYSIWYG available yet...)</label>
            <textarea name="body" id="body"  class="form-control" ></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Publish</button>
    </form>


    <br>
    @include('layouts.errors')

@endsection