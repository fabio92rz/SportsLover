@extends('layouts.app')
@section('content')
        <div class="panel-heading"><h2>I tuoi Post</h2></div>
    @foreach($posts as $post)
        <div>
        <div class="list-group">
            <div class="list-group-item">
                <div class="panel-heading">
                    <h4><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a></h4>
                    <h5>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a
                                href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></h5>
                    <h6><a href="{{ url('/category/'.$post->categoryname)}}">{{$post->categoryname}}</a></h6>
                </div>
                <div class="panel-body">
                    <p>{!! str_limit($post->body, $limit = 1500, $end = '....... <a class="btn btn-default" href='.url("/".$post->slug).'>Read More</a>') !!}</p>
                </div>
            </div>
        </div>
        </div>
    @endforeach
    <div class="ccol-md-3 col-lg-offset-5">
        {!! $posts->render() !!}
    </div>
@endsection


