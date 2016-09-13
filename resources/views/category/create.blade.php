@extends('layouts.app')
@section('title')
    Gestisci Categoria
@endsection
@section('content')
    <form method="post" action='{{ url("/store-category") }}'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <div class="form-group">
                <select name="categoryid" class="form-control">
                    @foreach($categories2 as $category)
                        <a href="{!! route('categoryid', ['id'=>$category->id]) !!}"></a>
                        <option value="{{$category->id}}"> {{$category->category}} </option>
                    @endforeach
                </select>
            </div>
            <input required="required" value="{{ old('category') }}" placeholder="Inserisci nuova Categoria" type="text"
                   name="category" class="form-control"/>
        </div>
        <input type="submit" name='publish' class="btn btn-success" value="Aggiungi"/>

        <a href="{{  url('delete-category/'.$category->id)}}" class="btn btn-danger">Elimina</a>
        <a href="{{  url('edit-category/'.$category->id) }}" class="btn btn-warning">Modifica</a>
    </form>
@endsection