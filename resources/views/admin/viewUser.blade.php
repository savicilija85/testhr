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
            <a href="{{route('admin.getUserIdCardImageBack', $user->id)}}">Zadnja strana</a>
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
