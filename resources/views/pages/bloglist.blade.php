@extends('layout.applayout') <!--- extends applayout.blade.php from views/layout/applayout.blade.php -->

@section('content')
	<br>
	<a class="btn btn-info" href="/bloglist/create">Create Post</a>
	<hr>
	@if(count($posts)>0)
		<h3>Your Blog Posts</h3>
		<br>
    	<table class="table table-stripeed">
            <tr>
                <th>Title</th>
                <th></th>
                <th></th>
            </tr>
        @foreach($posts as $post)
        	<tr>
                <td>{{$post->title}}</td>
                <td><a href="/bloglist/{{$post->id}}/edit" class="btn btn-info">Edit</a></td>
                <td>
                    {!! Form::open(['action' => ['BloglistController@destroy', $post->id],'method' => 'POST']) !!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </table>
	@else
        <h3>No post found</h3>
		<hr>
    @endif	
@endsection