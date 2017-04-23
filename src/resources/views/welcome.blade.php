@extends('layouts.app')
@section('styles')
    <style type="text/css">
        .jumbotron {
            position: relative;
            background: #FFFFFF url("/img/welcome.jpg") center center;
            margin-bottom: 0;
            min-height: 50%;
            height: 100vh;
            background-repeat: no-repeat;
            background-position: center;
            -webkit-background-size: cover;
            background-size: cover;
        }

        .navbar {
            margin-bottom: 0px;
        }

        .panel-body {
            background:#556175;}

        label{
            color:#FFFFFF;
        }

    </style>
@endsection
@section('content')
    <div class="jumbotron">
        <div class="container">

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">Bienvenido a {{ config('app.name', 'Laravel') }} <small> registrate para continuar</small></div>
                        <div class="panel-body">
                            @include('auth/registerpartial')
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

