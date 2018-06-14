@extends('layouts.main')

@section('title', '| Admin Provisions')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

                @if($provisions === null)
                    <table class="table table-user-information">
                        <tbody>
                        <tr>
                            <td colspan="11">No entries found.</td>
                        </tr>
                        </tbody>
                    </table>
                @else

                @forelse($currencies as $currency)

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$currency->name}}</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                {!! Form::open(['route' => 'admin.saveProvision']) !!}

                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>
                                            {{ Form::label($currency->short_name . 'buy', 'Kupovina:') }}
                                        </td>
                                        <td>
                                            {{ Form::text($currency->short_name . 'buy', null, ['class' => 'form-control','required' => '', 'pattern' => '\d{0,2}(\.\d{1,2})?', 'placeholder' => $provisions->{$currency->short_name . 'buy'} . ' %']) }}
                                        </td>
                                        <td>
                                            {{ Form::submit('Izmeni', ['class' => 'btn btn-primary'])}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                {!! Form::close() !!}

                                {!! Form::open(['route' => 'admin.saveProvision']) !!}

                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>
                                            {{ Form::label($currency->short_name . 'sell', 'Prodaja:', ['style' => 'padding-right: 12px']) }}
                                        </td>
                                        <td>
                                            {{ Form::text($currency->short_name . 'sell', null, ['class' => 'form-control','required' => '', 'pattern' => '\d{0,2}(\.\d{1,2})?', 'placeholder' => $provisions->{$currency->short_name . 'sell'} . ' %']) }}
                                        </td>
                                        <td>
                                            {{ Form::submit('Izmeni', ['class' => 'btn btn-primary'])}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    @empty
                        <table class="table table-user-information">
                            <tbody>
                        <tr>
                            <td colspan="11">No entries found.</td>
                        </tr>
                            </tbody>
                        </table>
                @endforelse
                    @endif
            </div>
        </div>
    </div>
@endsection