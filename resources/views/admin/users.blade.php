@extends('layouts.main')

@section('title', '| Admin users')

@section('content')
    <div class="container">
        <div class="row">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Ime</th>
            <th>Korisničko ime</th>
            <th>Verifikacija</th>
            <th>Akcije</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        @forelse($users as $user)
            <tr>
                <td><a href="{{route('admin.viewUser', $user->id)}}">{{ $user->name }}</a></td>
                <td><a href="{{route('admin.viewUser', $user->id)}}">{{ $user->username }}</a></td>
                <td>
                    @if($user->verified == 'uploaded')
                        <div style="color:darkorange;text-align: center;">
                            <br>
                            <b>Korisnik je uploadovao dokumenta</b>
                        </div>
                    @elseif($user->verified == 'verificated')
                        <div style="color:green;text-align: center;">
                            <br>
                            <b>Korisnik je verifikovan</b>
                        </div>
                    @else
                        <div style="color:red;text-align: center;">
                            <br>
                            <b>Korisnik nije uploadovao dokumenta</b>
                        </div>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-default">Edit</a>
                    {{ Form::open(['route' => ['admin.deleteUser', $user->id], 'method' => 'DELETE', 'style' => 'display: inline', 'onsubmit' => 'return confirm("Are you sure you want to delete user:' . $user->name . '?")']) }}

                    {{ Form::submit('Delete', ['class' => "btn btn-danger"]) }}

                    {{ Form::close() }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No entries found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
            <div id="paging"></div>
    {{--{{$users->links()}}--}}
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var data = document.getElementsByTagName("tr");
        function page() {
            var data1 = data;
            console.log(data1);
            for (var i = 1; i < data1.length; i++) {
                if (!(i > 5 && i <= 10)) {
                    console.log(i);
                    data1[i].remove();

                }
                data1 = data;
            }
        }
        $( document ).ready(function() {
            //var data = document.getElementsByTagName("tr");
            var data = $("tr");
            var pages = 0;

            for(var i = 1; i < data.length; i++){
                if(i % 5 === 0){
                    pages++;
                    $("#paging").append("<button onclick=\"page();\">" + pages + "</button>")
                }
            }

            console.log(pages);

            for(var j = 1; j < data.length; j++){
                if(j > 5){
                    console.log(j);
                    data[j].remove();
                    //debugger;
                }
            }
            console.log(data);

        });


        /*document.addEventListener("DOMContentLoaded", function(event) {
            var data = document.getElementById('tableBody');


        });*/

    </script>
    @endsection

