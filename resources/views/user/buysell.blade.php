@extends('layouts.main')

@section('title', '| Add Bank Account')

@section('content')

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">KUPOVINA/PRODAJA KRIPTOVALUTA</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            {{ Form::open(['route' => 'user.buysell.saveOrder']) }}

                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>
                                        {{ Form::label('buy_sell', 'Kupovina/Prodaja:') }}
                                    </td>
                                    <td>
                                        {{ Form::select('buy_sell', ['Kupovina' => 'Kupovina', 'Prodaja' => 'Prodaja']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ Form::label('currency', 'Kupovina/Prodaja:') }}
                                    </td>
                                    <td>
                                        {{ Form::select('currency', $currency) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ Form::label('quantity', 'Kolicina:') }}
                                    </td>
                                    <td>
                                        {{ Form::number('quantity', null, ['step' => '0.00000001', 'required' => '', 'pattern' => "[0-9]+([\.|,][0-9]+)?"]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ Form::submit('Potvrdi', ['class' => 'btn btn-primary'])}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection