@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    <dl class="dl-horizontal">
                        <dt>Trenutna cena:</dt>
                        <dd>{{ $resEur['result']['XXBTZEUR']['c'][0] }} EUR</dd>
                        <dd>{{ $resRsd['actual'] }} DIN</dd>
                    </dl>
                </div>
            </div>



            <div class="col-md-4">
                <div class="well">
                    <dl class="dl-horizontal">
                        <dt>Prodajna cena:</dt>
                        <dd>{{ $resEur['result']['XXBTZEUR']['a'][0] }} EUR</dd>
                        <dd>{{ $resRsd['ask'] }} DIN</dd>
                    </dl>
                </div>
            </div>



            <div class="col-md-4">
                <div class="well">
                    <dl class="dl-horizontal">
                        <dt>Kupovna cena:</dt>
                        <dd>{{ $resEur['result']['XXBTZEUR']['b'][0] }} EUR</dd>
                        <dd>{{ $resRsd['bid'] }} DIN</dd>
                    </dl>
                </div>
            </div>

        </div>
    </div>
@endsection
