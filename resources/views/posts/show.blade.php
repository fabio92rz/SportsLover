@extends('layouts.app')
@section('title')
    @if($post)
        {{ $post->title }}
        @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
            <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Modifica Post</a></button>
        @endif
    @else
        Page does not exist
    @endif
@endsection
@section('title-meta')
    <h3>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a
                href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></h3>

    <h4>Categoria: <a href="{{ url('/category/'.$post->categoryname)}}">{{$post->categoryname}}</a></h4>

@endsection
@section('content')
    @if($post)
        <div class="panel-body">
            {!! $post->body !!}
            <hr>
            <h2>Scrivi un commento</h2>
        </div>
        @if(Auth::guest())
            <p>Esegui il Login per commentare</p>
        @else
            <div class="panel-body">
                <form method="post" action='{{ url("/comment/add") }}'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="on_post" value="{{ $post->id }}">
                    <input type="hidden" name="slug" value="{{ $post->slug }}">
                    <div class="form-group">
                        <textarea required="required" placeholder="Enter comment here" name="body"
                                  class="form-control"></textarea>
                    </div>
                    <input type="submit" name='post_comment' class="btn btn-success" value="Post"/>
                </form>
            </div>
        @endif
        <div>
            @if($comments)
                <ul style="list-style: none; padding: 0">
                    @foreach($comments as $comment)
                        <li class="panel-body">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <h3>{{ $comment->author->name }}</h3>
                                    <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                </div>
                                <div class="list-group-item">
                                    <p>{{ $comment->body }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @else
        404 error
    @endif
@endsection