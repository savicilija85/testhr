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
                        <p>Molimo Vas da uplatite {{ $outputCurrencyAmount }} KN na:</p><br>
                        <p><strong>Uplatitelj:</strong> {{ $name }}</p>
                        <p><strong>Primatelj:</strong> Web Development DOO, Jastrebarska 3, Zagreb</p>
                        <p><strong>Broj računa:</strong> HR4124020061100856655</p>
                        <p><strong>Opis plaćanja:</strong> Nalog za kupnju</p>
                        <p><strong>Iznos:</strong> {{ $outputCurrencyAmount }} KN</p>
                        <br><hr>
                        <p><strong>Napomena: konačni obračun i konačna cijena kriptovalute se obračunavaju u trenutku same kupnje, tj. nakon što sredstva pristignu na naš račun i nakon što se obavi kupnja kriptovalute.</strong></p>
                        <br><br><br>
                        Web Development DOO, Jastrebarska 3, Zagreb
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection