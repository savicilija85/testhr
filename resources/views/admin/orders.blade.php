@extends('layouts.main')

@section('title', '| Admin orders')

@section('content')
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Korisnik</th>
            <th>Kupovina/Prodaja</th>
            <th>Kolicina</th>
            <th>Valuta</th>
            <th>Ukupan iznos</th>
            <th>Provizija</th>
            <th>PDV</th>
            <th>Iznos za isplatu</th>
            <th><span class="btn-success glyphicon glyphicon-ok"></span>/<span class="btn-danger glyphicon glyphicon-remove"></span></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                {{ Form::open(['route' => ['admin.updateOrder', $order->id], 'method' => 'PUT', 'style' => 'display: inline']) }}
                <td>{{ $order->id }}</td>
                <td>{{ App\User::find($order->user_id)->name }}</td>
                <td>{{ $order->buy_sell }}</td>
                <td>
                    {{ Form::number('quantity', null, ['class' => 'form-control','required' => '', 'step' => '0.00000001', 'pattern' => "[0-9]+([\.|,][0-9]+)?", 'placeholder'=> $order->quantity, 'value'=> $order->quantity]) }}
                </td>
                <td>{{ $order->currency }}</td>
                <td>
                    {{ Form::number('sum', null, ['class' => 'form-control','required' => '', 'step' => '0.00000001', 'pattern' => "[0-9]+([\.|,][0-9]+)?", 'placeholder'=> $order->sum, 'value'=> $order->sum]) }}
                </td>
                <td>{{ $order->provision }}</td>
                <td>{{ $order->pdv }}</td>
                <td>{{ $order->amount }}</td>
                <td>
                    @if($order->success == 0)
                        <span class="btn-danger glyphicon glyphicon-remove"></span>
                    @else
                        <span class="btn-success glyphicon glyphicon-ok"></span>
                    @endif

                </td>
                <td>
                    {{ Form::submit('Izmeni', ['class' => 'btn btn-primary btn-sm'])}}
                    {{ Form::close() }}

                    {{ Form::open(['route' => ['admin.updateOrderSuccess', $order->id], 'method' => 'POST', 'style' => 'display: inline']) }}
                    {{ Form::submit('Uspesno', ['class' => "btn btn-success btn-sm"]) }}
                    {{ Form::close() }}

                    {{ Form::open(['route' => ['admin.deleteOrder', $order->id], 'method' => 'DELETE', 'style' => 'display: inline', 'onsubmit' => 'return confirm("Are you sure you want to delete order no.:' . $order->id . '?")']) }}
                    {{ Form::submit('Izbrisi', ['class' => "btn btn-danger btn-sm"]) }}
                    {{ Form::close() }}

                </td>

            </tr>
        @empty
            <tr>
                <td colspan="11">No entries found.</td>
            </tr>
        @endforelse
        </tbody>

    </table>

    {{$orders->links()}}
    </div>
    </div>
    </div>
@endsection