<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/css/bootstrap-datepicker3.css" rel="stylesheet">
    <link href="/fonts/flaticon.css" rel="stylesheet">


    @yield('styles')
    <style type="text/css">
        .profile-usermenu {
            margin-top: 30px;
        }

        .profile-usermenu ul li {
            border-bottom: 1px solid #f0f4f7;
        }

        .profile-usermenu ul li:last-child {
            border-bottom: none;
        }

        .profile-usermenu ul li a {
            color: #93a3b5;
            font-size: 14px;
            font-weight: 400;
        }

        .profile-usermenu ul li a i {
            margin-right: 8px;
            font-size: 14px;
        }

        .profile-usermenu ul li a:hover {
            background-color: #fafcfd;
            color: #5b9bd1;
        }

        .profile-usermenu ul li.active {
            border-bottom: none;
        }

        .profile-usermenu ul li.active a {
            color: #5b9bd1;
            background-color: #f6f9fb;
            border-left: 2px solid #5b9bd1;
            margin-left: -2px;
        }

        .table-image {
            min-width: 40px;
            min-height: 40px;
            max-width: 40px;
            max-height: 40px;
        }

        .twPc-div {
            background: #fff none repeat scroll 0 0;
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            height: 200px;

        }

        .twPc-bg {
            background-image: url("https://pbs.twimg.com/profile_banners/50988711/1384539792/600x200");
            background-position: 0 50%;
            background-size: 100% auto;
            border-bottom: 1px solid #e1e8ed;
            border-radius: 4px 4px 0 0;
            height: 95px;
            width: 100%;
        }

        .twPc-block {
            display: block !important;
        }

        .twPc-button {
            margin: -35px -10px 0;
            text-align: right;
            width: 100%;
        }

        .twPc-avatarLink {
            background-color: #fff;
            border-radius: 6px;
            display: inline-block !important;
            float: left;
            margin: -30px 5px 0 8px;
            max-width: 100%;
            padding: 1px;
            vertical-align: bottom;
        }

        .twPc-avatarImg {
            border: 2px solid #fff;
            border-radius: 7px;
            box-sizing: border-box;
            color: #fff;
            height: 72px;
            width: 72px;
        }

        .twPc-divUser {
            margin: 5px 0 0;
        }

        .twPc-divName {
            font-size: 18px;
            font-weight: 700;
            line-height: 21px;
        }

        .twPc-divName a {
            color: inherit !important;
        }

        .twPc-divStats {
            margin-left: 11px;
            padding: 10px 0;
        }

        .twPc-Arrange {
            box-sizing: border-box;
            display: table;
            margin: 0;
            min-width: 100%;
            padding: 0;
            table-layout: auto;
        }

        ul.twPc-Arrange {
            list-style: outside none none;
            margin: 0;
            padding: 0;
        }

        .twPc-ArrangeSizeFit {
            display: table-cell;
            padding: 0;
            vertical-align: top;
        }

        .twPc-ArrangeSizeFit a:hover {
            text-decoration: none;
        }

        .twPc-StatValue {
            display: block;
            font-size: 18px;
            font-weight: 500;
            transition: color 0.15s ease-in-out 0s;
        }

        .twPc-StatLabel {
            color: #8899a6;
            font-size: 10px;
            letter-spacing: 0.02em;
            overflow: hidden;
            text-transform: uppercase;
            transition: color 0.15s ease-in-out 0s;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
    </style>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        <li><a href="{{ route('register') }}">Registrarse</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ empty(Auth::user()->perfil) ? Auth::user()->email :Auth::user()->perfil->nombre .' '. Auth::user()->perfil->apellido}}
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if(Auth::check() && !empty($profile))
        <div class="col-md-3">
            <div class="col-md-offset-1 col-md-11">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include("layouts.sidebar")
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">

            <div class="container-fluid">
                @yield('content')
            </div>

        </div>
    @else
        @yield('content')
    @endif


</div>

<div class="modal fade" id="alertModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="alertModalHeader"></h4>
            </div>
            <div class="modal-body" id="alertModalContent">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" id="btnAertModal"></button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="alertModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="alertModalHeader"></h4>
            </div>
            <div class="modal-body" id="alertModalContent">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" id="btnAertModal"></button>
            </div>
        </div>

    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
{{--<script>--}}
    {{--$(document).ready(function () {--}}
        {{--$.ajaxSetup({--}}
            {{--headers: {--}}
                {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--}--}}
        {{--});--}}
    {{--});</script>--}}
<script src="/js/common.js"></script>
@yield('scripts')
@yield('partial-scripts')

</body>
</html>
