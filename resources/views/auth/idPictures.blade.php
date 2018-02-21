@extends('layouts.main')

@section('title', '| User ID Card Pictures')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('idPictures') }}">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('id_card_image_front') ? ' has-error' : '' }}">
                                <label for="id_card_image_front" class="col-md-4 control-label">Slika lične karte prednja strana</label>

                                <div class="col-md-6">
                                    <input id="id_card_image_front" type="file" class="form-control" name="id_card_image_front" required>
                                    @if ($errors->has('id_card_image_front'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('id_card_image_front') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('id_card_image_back') ? ' has-error' : '' }}">
                                <label for="id_card_image_back" class="col-md-4 control-label">Slika lične karte zadnja strana</label>

                                <div class="col-md-6">
                                    <input id="id_card_image_back" type="file" class="form-control" name="id_card_image_back" required>
                                    @if ($errors->has('id_card_image_back'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('id_card_image_back') }}</strong>
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
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
