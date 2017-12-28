<div class="blog-masthead">
    <div class="container">
        <nav class="nav blog-nav">
            <a class="nav-link active" href="/">All posts</a>
            <a class="nav-link" href="/posts/create">Create new post</a>
            @if (Auth::check())
                <a class="nav-link" href="/{{ Auth::user()->id }}/posts/">My Posts</a>
                <a class="nav-link" href="/show_words_filter">Word`s Filter</a>
            @endif

            @if (Auth::check())
                <a class="nav-link ml-auto" href="/logout">Logout  : {{ Auth::user()->name }}</a>
            @else
                <a class="nav-link" href="/register">Register</a>
                <a class="nav-link  ml-auto" href="/login">Login</a>

            @endif

        </nav>
    </div>
</div>