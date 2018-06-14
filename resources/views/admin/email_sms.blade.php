@extends('layouts.main')

@section('title', '| Admin Dasboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info">

                    <div class="panel-heading">Pošalji Email</div>
                    <div class="panel-body">
                    {!! Form::open(['route' => 'admin.sendEmail', 'class' => 'form-horizontal']) !!}

                    {{ Form::label('email', 'Email:') }}
                    {{ Form::text('email', null, ['class' => 'form-control','required' => '']) }}

                    {{ Form::label('title', 'Naslov:') }}
                    {{ Form::text('title', null, ['class' => 'form-control','required' => '']) }}

                    {{ Form::label('body', 'Poruka:') }}
                    {{ Form::textarea('body', null, ['class' => 'form-control','required' => '', 'style' => 'white-space: pre-line;', 'wrap' => 'hard']) }}

                    {{ Form::submit('Pošalji', ['class' => 'btn btn-primary btn-block', 'style' => 'margin-top: 10px;'])}}

                    {!! Form::close() !!}

                    </div>
                </div>
            </div>

                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">Pošalji SMS</div>
                        <div class="panel-body">
                            {!! Form::open(['route' => 'admin.sendSms', 'class' => 'form-horizontal']) !!}

                            {{ Form::label('phone', 'Broj telefona:') }}
                            {{ Form::text('phone', null, ['class' => 'form-control','required' => '']) }}

                            {{ Form::label('message', 'Poruka:') }}
                            {{ Form::textarea('message', null, ['class' => 'form-control','required' => '']) }}

                            {{ Form::submit('Pošalji', ['class' => 'btn btn-primary btn-block', 'style' => 'margin-top: 10px;'])}}

                            {!! Form::close() !!}

                        </div>
                    </div>

            </div>
        </div>
    </div>
@endsection