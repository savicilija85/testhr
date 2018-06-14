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
                        <p>Vaša dokumenta su verifikovana, možete da nastavite da izvršavate transakcije</p><br>
                        <p>S poštovanjem,</p>

                        <br><br><br>
                        Crypto Plus DOO, Novi Sad
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection