@extends('layouts.admin')

@section('content')

    <h1>Create Post</h1>

    <div class="col-sm-3">

        <img class="img-responsive img-rounded" src="{{$post->photo_id ? "/codehacking/public/images/".$post->user_id."/".$post->photo->path : "/codehacking/public/images/unknown.png"}}" alt="">

    </div>

    <div class="col-sm-9">

        {!! Form::model($post, ['method'=>'PATCH', 'action'=>['AdminPostsController@update', $post->id], 'files'=>true]) !!}

            <div class="form-group">
                {!! Form::label('title', 'Title:') !!}
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('category_id', 'Category:') !!}
                {!! Form::select('category_id', [''=>'Choose Option']+$categories, null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('photo', 'Photo:') !!}
                {!! Form::file('photo', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('body', 'Description:') !!}
                {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>8]) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Create Post', ['class'=>'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}


        {!! Form::open(['method'=>'DELETE', 'action'=>['AdminPostsController@destroy', $post->id]]) !!}

            <div class="form-group">
                {!! Form::submit('Delete Post', ['class'=>'btn btn-danger']) !!}
            </div>

        {!! Form::close() !!}

    </div>

@endsection