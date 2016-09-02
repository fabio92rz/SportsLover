@extends('layouts.app')
@section('title')

@endsection
@section('content')
@foreach ($posts as $post)
    {{ $post->body }}
@endforeach
@endsection