<div class="blog-post">
    <h2 class="blog-post-title">
        <a  href="/posts/{{$post->id}}">
            {{$post->title}}
            <br>
            @if (file_exists(public_path() .'/img/' .$post->img))
                <img src="\img\{{$post->img}} "  width="40%" height="40%">
            @endif
        </a>


    </h2>

    <p class="blog-post-meta">
        {{$post->user->name}} on
        {{$post->created_at->toFormattedDateString()}}</p>

    <p>{{$post->body}}</p>
</div><!-- /.blog-post -->