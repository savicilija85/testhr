@extends('layouts.mail')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
            <div class="row">
                {!! nl2br(e($body)) !!}
            </div>
        </div>
    </div>
@endsection
