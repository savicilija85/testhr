@extends('layouts.main')

@section('title', '| Admin orders')

@section('content')
    <div class="container-fluid">
    <div class="row">

    <table class="table table-bordered">
        <thead style="font-size: 12px">
        <tr>
            <th>Id</th>
            <th>Korisnik</th>
            <th>Adresa</th>
            <th>Kupovina/Prodaja</th>
            <th>Wallet</th>
            <th>Destination Tag</th>
            <th>Količina</th>
            <th>Valuta</th>
            <th>Ukupan iznos</th>
            <th>Provizija</th>
            <th>Neto iznos</th>
            <th><span class="btn-success glyphicon glyphicon-ok"></span>/<span class="btn-danger glyphicon glyphicon-remove"></span></th>
            <th></th>
            <th>Datum</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                @if($order->success == 0)
                {{ Form::open(['route' => ['admin.updateOrder', $order->id], 'method' => 'PUT', 'style' => 'display: inline']) }}
                <td>{{ Form::text('account_number', null, ['style' => 'margin-right: -80px;','class' => 'form-control','required' => '', 'pattern' => "[0-9]+([\.|,][0-9]+)?", 'placeholder'=> $order->account_number, 'value'=> $order->account_number]) }}</td>
                <td><div style="font-size: 12px;">{{ App\User::find($order->user_id)->name }}</div></td>
                <td><div style="font-size: 12px;">{{ $order->address }}</div></td>
                <td><div style="font-size: 12px;">{{ $order->buy_sell }}</div></td>
                <td><div style="font-size: 12px;">{{ $order->wallet }}</div></td>
                <td><div style="font-size: 12px;">{{ $order->destination_tag }}</div></td>
                <td>
                    {{ Form::text('quantity', null, ['style' => 'margin-right: -50px;', 'class' => 'form-control','required' => '', 'step' => '0.00000001', 'pattern' => "[0-9]+([\.|,][0-9]+)?", 'placeholder'=> $order->quantity, 'value'=> $order->quantity]) }}
                </td>
                <td><div style="font-size: 12px;">{{ $order->currency }}</div></td>
                <td>
                    {{ Form::text('sum', null, ['style' => 'margin-right: -50px;', 'class' => 'form-control','required' => '', 'step' => '0.00000001', 'pattern' => "[0-9]+([\.|,][0-9]+)?", 'placeholder'=> $order->sum, 'value'=> $order->sum]) }}
                </td>
                <td><div style="font-size: 12px;">{{ $order->provision }}</div></td>
                <td><div style="font-size: 12px;">{{ $order->pdv }}</div></td>
                <td><div style="font-size: 12px;">{{ $order->amount }}</div></td>
                <td>
                        <span class="btn-danger glyphicon glyphicon-remove"></span>
                </td>
                <td>
                    {{ Form::submit('Izmeni', ['class' => 'btn btn-primary btn-sm'])}}
                    {{ Form::close() }}

                    {{ Form::open(['route' => ['admin.updateOrderSuccess', $order->id], 'method' => 'POST', 'style' => 'display: inline']) }}
                    {{ Form::submit('Uspešno', ['class' => "btn btn-success btn-sm"]) }}
                    {{ Form::close() }}

                    {{ Form::open(['route' => ['admin.deleteOrder', $order->id], 'method' => 'DELETE', 'style' => 'display: inline', 'onsubmit' => 'return confirm("Are you sure you want to delete order no.:' . $order->id . '?")']) }}
                    {{ Form::submit('Poništi', ['class' => "btn btn-danger btn-sm"]) }}
                    {{ Form::close() }}
                </td>
                <td><div style="font-size: 12px;">{{ $order->created_at }}</div></td>
                    @else
                    <td>{{  $order->account_number }}</td>
                    <td><div style="font-size: 12px;">{{ App\User::find($order->user_id)->name }}</div></td>
                    <td><div style="font-size: 12px;">{{ $order->address }}</div></td>
                    <td><div style="font-size: 12px;">{{ $order->buy_sell }}</div></td>
                    <td><div style="font-size: 12px;">{{ $order->wallet }}</div></td>
                    <td><div style="font-size: 12px;">{{ $order->destination_tag }}</div></td>
                    <td> {{ $order->quantity }} </td>
                    <td><div style="font-size: 12px;">{{ $order->currency }}</div></td>
                    <td> {{ $order->sum }} </td>
                    <td><div style="font-size: 12px;">{{ $order->provision }}</div></td>
                    <td><div style="font-size: 12px;">{{ $order->amount }}</div></td>
                    <td>
                        <span class="btn-success glyphicon glyphicon-ok"></span>
                    </td>
                    <td>
                            <div style="color:green;text-align: center;">
                                <b>Nalog je obrađen</b>
                            </div>
                    </td>
                    <td><div style="font-size: 12px;">{{ $order->created_at }}</div></td>
                    @endif
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
@endsection