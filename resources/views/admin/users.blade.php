@extends('layouts.main')

@section('title', '| Admin users')

@section('content')
    <div class="container">
        <div class="row">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td><a href="{{route('admin.viewUser', $user->id)}}">{{ $user->name }}</a></td>
                <td><a href="{{route('admin.viewUser', $user->id)}}">{{ $user->username }}</a></td>
                <td>
                    <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-default">Edit</a>
                    {{ Form::open(['route' => ['admin.deleteUser', $user->id], 'method' => 'DELETE', 'style' => 'display: inline', 'onsubmit' => 'return confirm("Are you sure you want to delete user:' . $user->name . '?")']) }}

                    {{ Form::submit('Delete', ['class' => "btn btn-danger"]) }}

                    {{ Form::close() }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No entries found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$users->links()}}
        </div>
    </div>
@endsection
