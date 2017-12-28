@extends('layouts.master')

@section('content')
    @if ($filter)
    <form method="post" action="/update_words_filter" enctype="multipart/form-data" >
        {{csrf_field()}}
        {{--{{ method_field('PATCH') }}--}}
        <h2>Измените или добавьте слова для фильтра</h2>
        <p>(Cлова следует записывать в строку через запятую)</p>
        <div class="form-group" >
            <textarea id="body" name="body" style="width: 90%;height:150px;" >{{$filter->body}} </textarea>
        </div>

        <button type="submit" class="btn btn-success"> Save changes</button>
    </form>
    @else
        <form method="post" action="/store_words_filter" enctype="multipart/form-data">
            {{csrf_field()}}
            {{--{{ method_field('PATCH') }}--}}
            <h2>Добавьте слова для фильтра</h2>
            <p>(Cлова следует записывать строкой через запятую)</p>
            <div class="form-group" >
                <textarea id="body" name="body" style="width: 90%;height:150px;"> </textarea>
            </div>

            <button type="submit" class="btn btn-success"> Save </button>
        </form>
    @endif
    <br>
    <hr>




<br>

            @include('layouts.errors')

@endsection