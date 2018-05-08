@extends('layout.applayout') <!--- extends applayout.blade.php from views/layout/applayout.blade.php -->

@section('content')

	<br>
	<h3>Create your post</h3>
	<hr>
	{!! Form::open(['action' => 'BloglistController@store','method' => 'POST','enctype'=>'multipart/form-data']) !!}
	<div class="form-group">
            {{Form::label('title','Title')}}
            {{Form::text('title','',['class' => 'form-control','placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body','Body')}}
            {{Form::textarea('body','',['id' => 'body-ckeditor', 'class' => 'form-control','placeholder' => 'Body Text'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    

    <script type="text/javascript">
        CKEDITOR.replace( 'body-ckeditor' );
    </script>
@endsection