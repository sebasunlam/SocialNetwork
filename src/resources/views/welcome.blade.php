@extends('layouts.app')
@section('styles')
    <style type="text/css">
        .jumbotron {
            position: relative;
            background: #FFFFFF url("/img/welcome_option.jpg") center center;
            margin-bottom: 0;
            min-height: 50%;
            height: 100vh;
            background-repeat: no-repeat;
            background-position: center;
            -webkit-background-size: cover;
            background-size: cover;
        }

        .has-error .control-label,
        .has-error .help-block,
        .has-error .form-control-feedback {
            color: #e53d3d;
        }

        /* Color of valid field */
        .has-success .control-label,
        .has-success .help-block,
        .has-success .form-control-feedback {
            color: #e53d3d;
        }

        .navbar {
            margin-bottom: 0px;
        }

        .panel-body {
            background: #556175;
        }

        label {
            color: #FFFFFF;
        }

    </style>
@endsection
@section('content')
    <div class="jumbotron">
        <div class="container">

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">Bienvenido a <strong>{{ config('app.name', 'Laravel') }}</strong>
                            <small> registrate para continuar</small>
                        </div>
                        <div class="panel-body">
                            @include('auth.registerpartial')
                            <div class="row">
                                <p class="lead">
                                    Tambien podes usar tu red social favorita
                                </p>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{route('redirectProvider',['provider'=>'facebook'])}}"
                                           class="btn btn-primary"><i class="fa fa-facebook"></i> |
                                            Facebook
                                        </a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{route('redirectProvider',['provider'=>'google'])}}"
                                           class="btn btn-danger"><i class="fa fa-google"></i> |
                                            Google
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
@endsection

