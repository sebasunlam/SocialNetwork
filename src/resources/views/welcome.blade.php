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

        p {
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
                                <p class="col-md-offset-1 lead">
                                    Tambien podes usar tu red social favorita
                                </p>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        @include('shared.socialbuttons')
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
@endsection

