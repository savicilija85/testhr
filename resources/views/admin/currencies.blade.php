@extends('layouts.main')

@section('title', '| Admin Currencies')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Kripto Valute</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                    @foreach($currencies as $currency)
                        <tr>
                        <td>
                            {{ $currency->name }} : {{ $currency->short_name }}
                            {{ Form::open(['route' => 'admin.saveMinimums', 'method' => 'POST', 'class' => 'form-horizontal col-md-12']) }}
                            <div class="form-inline">
                            {{ Form::label('min_sell', "Min prodaja:") }}&nbsp&nbsp&nbsp
                            {{ Form::text('min_sell', null, ['class' => 'form-control','required' => '', 'style' => 'width: 160px;', 'placeholder' => $currency->min_sell]) }}&nbsp{{ $currency->short_name }}
                            </div>
                            <br>
                            <div class="form-inline">
                            {{ Form::label('min_buy', 'Min kupovina:') }}
                            {{ Form::text('min_buy', null, ['class' => 'form-control','required' => '', 'style' => 'width: 160px;', 'placeholder' => $currency->min_buy]) }}&nbspRSD
                            </div>
                            {{ Form::hidden('short_name', $currency->short_name) }}
                            {{ Form::submit('Snimi', ['class' => 'btn btn-primary'])}}
                            {{ Form::close() }}
                            <form action="{{route('admin.deleteCryptoCurrency', $currency->id)}}" method="POST"
                                  style="display: inline"
                                  onsubmit="return confirm('Are you sure you want to delete currency: {{$currency->name}} : {{ $currency->short_name }}?');">
                                <input type="hidden" name="_method" value="DELETE">
                                {{ csrf_field() }}
                                <button class="btn-danger pull-right"><span class="glyphicon glyphicon-trash"></span></button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                                </tbody>
                            </table>
            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Nova Kripto Valuta</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            {{ Form::open(['route' => 'admin.createCryptoCurrency', 'method' => 'POST', 'class' => 'form-horizontal col-md-12']) }}

                            {{ Form::label('name', 'Ime:') }}

                            {{ Form::text('name', null, ['class' => 'form-control','required' => '']) }}

                            {{ Form::label('short_name', 'Skraceno Ime:') }}

                            {{ Form::text('short_name', null, ['class' => 'form-control','required' => '']) }}
                            <hr>
                            {{ Form::submit('Snimi', ['class' => 'btn btn-primary'])}}

                            {{ Form::close() }}
                        </div>
                    </div>
            </div>
        </div>

            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Skracenice kriptovaluta koje postoje na Krakenu</h3>
                    </div>

                    <ul class="list-group">
                        @foreach(array_keys($cryptoCurrencies) as $price)
                            @if ($price !== 'XXDG' && $price !== 'USDT' && $price !== 'XMLN' && $price !== 'XICN' && $price !== 'EOS' && $price !== 'GNO' && $price !== 'KFEE' && $price[0] !== 'Z')
                            <li class="list-group-item">
                                {{ $price }}
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

    </div>
    </div>
@endsection
