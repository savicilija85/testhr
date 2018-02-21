@extends('layouts.main')

@section('title', '| Admin Categories')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                Kategorije:
                <hr>
                <ul class="list-group">
                    @foreach($categories as $category)
                    <li class="list-group-item">
                        {{ $category->name }}
                        <form action="{{route('admin.deleteCategory', $category->id)}}" method="POST"
                              style="display: inline"
                              onsubmit="return confirm('Are you sure you want to delete user: {{$category->name}}?');">
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            <button class="btn-danger pull-right"><span class="glyphicon glyphicon-trash"></span></button>
                        </form>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-4">
                Nova kategorija:
                <hr>
                <form class="form-horizontal" action="{{ route('admin.createCategory') }}" method="POST">
                    {{ csrf_field() }}
                    <input id="name" type="text" class="form-control" name="name" required>
                    <br>
                    <button type="submit" class="btn btn-primary">
                        Confirm
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection
