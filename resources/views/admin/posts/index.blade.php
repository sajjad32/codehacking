@extends('layouts.admin')

@section('content')

    @if(Session::has('edited_user'))

        <p>{{session('edited_user')}}</p>

    @endif

    <h1>Posts</h1>

    @if($posts)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>User</th>
                    <th>Category ID</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Updated at</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td><img class="img-rounded" width="80" src="{{$post->photo_id ? "../images/".$post->user_id."/".$post->photo->path : '../images/unknown.png'}}" alt=""></td>
                        <td>{{$post->user->name}}</td>
                        <td>{{$post->category->name}}</td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->body}}</td>
                        <td>{{$post->updated_at->diffForhumans()}}</td>
                        <td><a href="{{route('admin.posts.edit', $post->id)}}">edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection