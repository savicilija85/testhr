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
                        <p>Molimo Vas da uplatite {{ $outputCurrencyAmount }} dinara na:</p><br>
                        <p><strong>Uplatilac:</strong> {{ $name }}</p>
                        <p><strong>Primalac:</strong> Crypto Plus DOO, Novi Sad</p>
                        <p><strong>Broj računa:</strong> 310-218098-87</p>
                        <p><strong>Svrha uplate:</strong> Uplata po nalogu</p>
                        <p><strong>Iznos:</strong> {{ $outputCurrencyAmount }}</p>
                        <p><strong>Poziv na broj:</strong> 221</p><br><hr>
                        <p><strong>Napomena: konačni obračun i konačna cena kriptovalute se obračunavaju u trenutku same kupovine, tačnije nakon što sredstva pristignu na naš račun i nakon što se obavi kupovina kriptovalute.</strong></p>
                        <br><br><br>
                        Crypto Plus DOO, Novi Sad
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection