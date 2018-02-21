@extends('layouts.main')

@section('title', '| My Account')

@section('content')
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">PODACI ZA PRIJAVU</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <table class="table table-user-information">
                                    <tbody>

                                    <tr>
                                        <td>Korisničko ime:</td>
                                        <td>{{$user->username}}</td>
                                    </tr>
                                    <tr>
                                        <td>Lozinka:</td>
                                        <td>
                                            **********
                                            <a href="{{route('user.myAccount.showChangePassword')}}" class="btn btn-default pull-right">Izmeni</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>E-mail:</td>
                                        <td>{{$user->email}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">LIČNI I KONTAKT PODACI</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <table class="table table-user-information">
                                <tbody>

                                <tr>
                                    <td>Ime i prezime:</td>
                                    <td>
                                        {{$user->name}}
                                        <a href="{{route('user.myAccount.showChangePersonalData')}}" class="btn btn-default pull-right">Izmeni</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mobilni:</td>
                                    <td>
                                        {{$user->phone}}
                                        <a href="{{route('user.myAccount.showChangePersonalData')}}" class="btn btn-default pull-right">Izmeni</a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">RAČUNI U BANCI</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>Broj računa:</td>
                                    <td>
                                        @foreach($user->accounts as $account)
                                            {{ $account['account_no'] }}
                                            <!--<a href="{{route('user.myAccount.deleteBankAccount', $account->id)}}" class="btn btn-danger pull-right">Izbriši</a>-->
                                            <form action="{{route('user.myAccount.deleteBankAccount', $account->id)}}" method="POST"
                                                  style="display: inline"
                                                  onsubmit="return confirm('Are you sure you want to delete account: {{$account->account_no}}?');">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger pull-right">Izbriši</button>
                                            </form>
                                            <br><br>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <a href="{{route('user.myAccount.showAddBankAccount')}}" class="btn btn-primary pull-right">Dodaj</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                    </div>
                </div>

            </div>
    </div>
    @endsection