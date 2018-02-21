@extends('layouts.mail')

@section('content')
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Poštovani {{ $name }}</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <p>Molimo Vas da pošaljete tačno <strong>{{ $quantity }} {{ $currency }}</strong> na Wallet:</p><br>
                        @if($currency == 'XRP')
                        <p><strong>Wallet:</strong> {{ $wallet }}</p>
                        <p><strong>Destination Tag:</strong> {{ $destination_tag }}</p><br>
                        <hr>
                        @else
                        <p><strong>Wallet:</strong> {{ $wallet }}</p><br>
                        <hr>
                        @endif
                        <p>Molimo Vas da vodite računa prilikom slanja i unosa adrese Walleta i destination tag-a za Ripple.</p>
                        <p><strong>Za pogrešno unete adrese ne odgovaramo!!!</strong></p><br><br>
                        <p><strong>Napomena: konačni obračun i konačna cena kriptovalute se obračunavaju u trenutku same prodaje, tj. nakon što kriptovaluta pristignu na naš wallet i nakon što se obavi prodaja kriptovalute.</strong></p>
                        <br><br><br>
                        Web Development DOO, Jastrebarska 3, Zagreb
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection