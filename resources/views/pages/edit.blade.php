@extends('layout.applayout') <!--- extends applayout.blade.php from views/layout/applayout.blade.php -->

@section('content')


	<a href="/bloglist" class="btn btn-info">Go Back</a>
	<h1>Edit Post</h1>
    <!--since in php artisan route:list posts.update needs a put|patch method and this method cannot be change from 
        POST to PUT below is a hidden form to spoof put -->
    @foreach($posts as $post)
	    {!! Form::open(['action' => ['BloglistController@update',$post->id],'method' => 'POST','enctype'=>'multipart/form-data']) !!}
	        <div class="form-group">
	            {{Form::label('title','Title')}}
	            {{Form::text('title',$post->title,['class' => 'form-control','placeholder' => 'Title'])}}
	        </div>
	        <div class="form-group">
	            {{Form::label('body','Body')}}
	            {{Form::textarea('body',$post->body,['id' => 'body-ckeditor', 'class' => 'form-control','placeholder' => 'Body Text'])}}
	        </div>
	        
	        <div class="form-group">
	                {{Form::file('image')}}
	            </div>
	            
	        <!--since in php artisan route:list posts.update needs a put|patch method this will going to spoof a put method -->
	        {{Form::hidden('oldimage',$post->image)}} 
	        {{Form::hidden('_method','PUT')}} 
	        {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
	    {!! Form::close() !!}
    @endforeach
    

    <script type="text/javascript">
        CKEDITOR.replace( 'body-ckeditor' );
    </script>
@endsection