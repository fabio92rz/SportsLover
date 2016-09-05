@extends('layouts.app')
@section('title')
    {{$title}}
@endsection

<!-- Header Carousel -->
<header id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
            <div class="carousel-caption">
            </div>
        </div>
        <div class="item">
            <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Two');"></div>
            <div class="carousel-caption">
            </div>
        </div>
        <div class="item">
            <div class="fill"
                 style="background-image:url('http://95.85.23.84/profilePicture/lanson_wimbledon2015.jpg');"></div>
            <div class="carousel-caption">
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="icon-next"></span>
    </a>
</header>
@section('title')
    Ultimi Post
@endsection
@section('content')
    @foreach($posts as $post)
        <div class="col-md-4">
            <div class="panel panel-default">
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
    @endforeach
@endsection
