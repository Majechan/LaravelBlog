@extends('layout.applayout') <!--- extends applayout.blade.php from views/layout/applayout.blade.php -->

@section('content')
	<a href="/" class="btn btn-info">Go Back</a>
    @foreach($posts as $post)
	    <h1>{{$post->title}}</h1>
	    <img style ="width:100%" src="/storage/images/{{$post->image}}">
	    <br>
	    <hr>
	    <br>
	    <div>
	        {!!$post->body!!}
	    </div>
	    <hr>
	    <small>Written on {{$post->created_at}} by {{$post->name}}</small>
	    <hr>
	    @if((!Auth::guest())&&(Auth::user()->id == $post->createdby))
	        <a href="/bloglist/{{$post->id}}/edit" class="btn btn-primary">Edit</a>
	        {!! Form::open(['action' => ['BloglistController@destroy', $post->id],'method' => 'POST','class' => 'float-right']) !!}
	            {{Form::hidden('_method','DELETE')}}
	            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
	        {!! Form::close() !!}
	    @endif
    @endforeach
@endsection