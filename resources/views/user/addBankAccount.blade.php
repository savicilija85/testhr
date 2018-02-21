@extends('layouts.main')

@section('title', '| Add Bank Account')

@section('content')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">DODAVANJE NOVOG BANKOVNOG RAČUNA</h3>
                    </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <form class="form-horizontal" method="POST" action="{{ route('user.myAccount.addBankAccount') }}">
                                    {{ csrf_field() }}
                                <label for="account" class="col-md-4 control-label">Broj računa</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="accountSmall[]" required pattern="[0-9]*" placeholder="000" maxlength="3" size="3">
                                            <span class="input-group-addon">-</span>
                                            <input type="text" class="form-control" name="accountLarge[]" required pattern="[0-9]*" placeholder="000000000000" maxlength="13" size="13">
                                            <span class="input-group-addon">-</span>
                                            <input type="text" class="form-control" name="accountMini[]" required pattern="[0-9]*" placeholder="00" maxlength="2" size="2">
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary pull-right">
                                            Dodaj
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>

@endsection