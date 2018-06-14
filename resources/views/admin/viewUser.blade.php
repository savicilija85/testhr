@extends('layouts.main')

@section('title', "| Admin View User: $user->name")

@section('content')
    <div class="container">
        <div class="row">
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Ime i prezime</th>
        <th>Korisnicko ime</th>
        <th>Email</th>
        <th>Telefon</th>
        <th>Racuni</th>
        <th>Licna karta</th>
        <th>Verifikacija</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>
        @foreach($user->accounts as $account)
        {{ $account['account_no'] }} <br>
        @endforeach
        </td>
        <td>
            <a href="{{ route('admin.getUserIdCardImageFront',$user->id) }}">Prednja strana</a><br>
            <a href="{{route('admin.getUserIdCardImageBack', $user->id)}}">Zadnja strana</a><br>
            <a href="{{route('admin.getUserIdCardImageSelfie', $user->id)}}">Selfie</a>
        </td>
        <td>
            @if($user->verified == 'uploaded')
                {{ Form::open(['route' => ['admin.updateVerifiedUser', $user->id], 'method' => 'POST', 'style' => 'display: inline;text-align: center;margin-top: 12px;']) }}
                {{ Form::submit('Verifikuj', ['class' => "btn btn-success btn-sm"]) }}
                {{ Form::close() }}

                {{ Form::open(['route' => ['admin.denyVerifiedUser', $user->id], 'method' => 'POST', 'style' => 'display: inline;text-align: center;margin-top: 12px;']) }}
                {{ Form::submit('Odbij', ['class' => "btn btn-danger btn-sm"]) }}
                {{ Form::close() }}
            @elseif($user->verified == 'verificated')
                <div style="color:green;text-align: center;">
                    <br>
                    <b>Korisnik je verifikovan</b>
                </div>
            @else
                <div style="color:red;text-align: center;">
                    <br>
                    <b>Korisnik nije uploadovao dokumenta</b>
                </div>
            @endif
        </td>
    </tr>
   @if($user == null)
    <tr>
        <td colspan="4">No entries found.</td>
    </tr>
    @endif
    </tbody>
</table>

<a href="{{ route('admin.users') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
@endsection
