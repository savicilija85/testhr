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

                        <p>Vaš nalog za prodaju je uspešno realizovan, u prilogu se nalazi obračun Vaše prodaje.</p>
                        <p>Hvala na poverenju,</p>
                        <br><br>
                        Crypto Plus DOO, Novi Sad
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection