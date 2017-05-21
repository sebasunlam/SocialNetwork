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

        .table-image{
            min-width: 40px;
            min-height: 40px;
            max-width: 40px;
            max-height: 40px;
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
<script src="/js/common.js"></script>
@yield('scripts')

</body>
</html>
