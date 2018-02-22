@extends('layouts.mail')

@section('content')
<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">PODACI PORUDŽBINE</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <table class="table table-user-information">
                        <tbody>

                        <tr>
                            <td>Ime:</td>
                            <td>{{$name}}</td>
                        </tr>

                        <tr>
                            <td>Adresa:</td>
                            <td>{{ $address }}</td>
                        </tr>

                        <tr>
                            <td>E-mail:</td>
                            <td>{{ $email }}</td>
                        </tr>

                        <tr>
                            <td>Telefon:</td>
                            <td>{{ $phone }}</td>
                        </tr>

                        <tr>
                            <td>Kupovina/Prodaja:</td>
                            <td>{{ $buy_sell }}</td>
                        </tr>

                        <tr>
                            <td>Valuta:</td>
                            <td>{{ $currency }}</td>
                        </tr>

                        <tr>
                            <td>Količina:</td>
                            <td>{{ $quantity }}</td>
                        </tr>

                        <tr>
                            <td>Wallet:</td>
                            <td>{{ $walletAddress }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection