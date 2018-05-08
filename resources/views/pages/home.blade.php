@extends('layout.applayout') <!--- extends applayout.blade.php from views/layout/applayout.blade.php -->

@section('content')
	<!--div class="card-header">
		Blog List
	</div-->
	<br>
	@if(count($posts)>0)
		<h3>Blog Posts</h3>
		<hr>
        @foreach($posts as $post)
        	<div class="card card-body bg-light">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style ="width:100%" src="/storage/images/{{$post->image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/bloglist/{{$post->id}}">{{$post->title}}</a></h3>
                        <small>Written on {{$post->created_at}} by {{$post->name}}</small>
                    </div>
                </div>
                
            </div>
            <br>
         @endforeach
	@else
        <h3>No post found</h3>
        <hr>
    @endif	
@endsection