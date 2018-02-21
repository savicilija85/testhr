@extends('layouts.main')

@section('title', '| Admin Dashboard')

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Admin Login</h3>
                </div>

                <div class="panel-body">
            {!! Form::open(['route' => 'admin.login', 'method' => 'POST']) !!}

            {{ Form::label('username', 'Username:') }}
            {{ Form::text('username', null, ['class' => 'form-control','required' => '', 'minlength' => '5']) }}

            {{ Form::label('password', 'Password:') }}
            {{ Form::password('password', ['class' => 'form-control','required' => '', 'minlength' => '5']) }}

            {{ Form::submit('Login', ['class' => 'btn btn-primary btn-lg btn-block', 'style' => 'margin-top: 20px'])}}
            {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
