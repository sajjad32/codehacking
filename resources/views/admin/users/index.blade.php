@extends('layouts.admin')


@section('content')

    @if(Session::has('edited_user'))

        <p>{{session('edited_user')}}</p>

    @endif


    <h1>Users</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
        @if($users)
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><img width="80" src="{{$user->photo ? "..//images/" . $user->photo->path : '../images/unknown.png'}}" alt="" class="img-rounded"></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>
                        {{$user->is_active == 1 ? 'active' : 'not active'}}
                    </td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td><a href="{{route('admin.users.edit', $user->id)}}">edit</a></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

@endsection