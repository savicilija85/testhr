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
                        <p>Vaši pristupni podaci za portal Cryptoplus.hr su:</p><br>

                            <p><strong>Korisničko ime:</strong> {{ $username }}</p>
                            <p><strong>E-mail:</strong> {{ $email }}</p><br>
                            <p><strong>Šifra:</strong> {{ $password }}</p><br>
                            <br><hr>

                        <br><br><br>
                        Web Development DOO, Jastrebarska 3, Zagreb
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection