@extends('layouts.main')

@section('title', '| Sms Verification')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('checkVerificationCode') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('user_verification_code') ? ' has-error' : '' }}">
                                <label for="user_verification_code" class="col-md-4 control-label">Verifikacioni kod:</label>

                                <div class="col-md-6">
                                    <input id="user_verification_code" type="text" class="form-control" name="user_verification_code" autofocus>
                                    @if ($errors->has('user_verification_code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('user_verification_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <input type="text" name="name" value={{$data['name']}} hidden>
                            <input type="text" name="username" value={{$data['username']}} hidden>
                            <input type="text" name="email" value={{$data['email']}} hidden>
                            <input type="text" name="phone" value={{$data['phone']}} hidden>
                            <input type="text" name="password" value={{$data['password']}} hidden>
                            <input type="text" name="verification_code" value={{$data['verification_code']}} hidden>
                            @foreach($data['accountSmall'] as $accountSmall)
                            <input type="text" name="accountSmall[]" value={{$accountSmall}} hidden>
                            @endforeach
                            @foreach($data['accountLarge'] as $accountLarge)
                                <input type="text" name="accountLarge[]" value={{$accountLarge}} hidden>
                            @endforeach
                            @foreach($data['accountMini'] as $accountMini)
                                <input type="text" name="accountMini[]" value={{$accountMini}} hidden>
                            @endforeach
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                    <button type="submit" formaction="{{route('resendVerificationCode')}}" class="btn btn-primary">
                                        Posalji ponovo
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
