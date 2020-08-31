@extends('home')

@section('title', 'Bảng điều khiển')

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card center">
                <div class="header">
                    <h2>
                        {{ config('app.name') }}
                    </h2>
                </div>
                <div class="body">
                    <h1>Xin chào, {{ auth()->user() ->name}}</h1>
                    <br/>
                </div>
            </div>
        </div>
    </div>
@endsection