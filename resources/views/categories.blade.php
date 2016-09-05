@extends('layouts.app')
@section('title')
    Ultimi Post
@endsection
@section('content')
    @foreach($posts as $post)
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></h5>
                    <h6><a href="{{ url('/'.$post->categoryname)}}">{{$post->categoryname}}</a></h6>
                </div>
                <div class="panel-body">
                    <p>{!! str_limit($post->body, $limit = 1500, $end = '....... <a class="btn btn-default" href='.url("/".$post->slug).'>Read More</a>') !!}</p>
                </div>
            </div>
        </div>
    @endforeach
@endsection


