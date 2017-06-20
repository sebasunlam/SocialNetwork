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
    @yield('partial-styles')
    <style>
        .black-background {
            background-color: #000000;
        }

        .white {
            color: #ffffff;
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
    <nav class="navbar navbar-default navbar-static-top">
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
                @if(Auth::check())
                    <div class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" data-provide="typeahead" placeholder="buscar..." autocomplete="off"
                                   class="form-control" id="mascotaTypeahead">
                        </div>
                    </div>
            @endif
            <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{route("perdido.all")}}">Ver mascotas perdidas</a></li>
                        <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                        <li><a href="{{ route('register') }}">Registrarse</a></li>
                    @else
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false" id="linkCitas">Citas <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route("citas.lista")}}">Ver citas</a></li>
                                <li><a href="{{route("citas.buscar")}}">Buscar citas</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false" id="linkPerdido">Perdidos <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route("perdido.all")}}">Ver mascotas perdidas</a></li>
                                <li><a href="{{route("perdido.encontrados")}}">Novedades sobre mis mascotas perdidas</a>
                                </li>
                            </ul>
                        </li>
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
        <div class="col-md-7">

            <div class="container-fluid">
                @yield('content')
            </div>

        </div>
        <div class="col-md-2">
            @include("layouts.infobar")
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


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function () {

        var $input = $("#mascotaTypeahead");


        $.get("{{route('mascota.all')}}" + $input.val(), function (data) {
            console.log(data);
            $input.typeahead({
                templates: {
                    empty: [
                        '<div class="empty-message">',
                        'No se encontraron resultados',
                        '</div>'
                    ].join('\n')
                },
                source: data,
                autoSelect: false
            });
        }, 'json');


        $input.change(function () {
            var current = $input.typeahead("getActive");

            if (current) {
                // Some item from your model is active!
                if (current.id != undefined)
                    window.location = "{{route('mascota.show',['id'=>-1])}}".replace("-1", current.id);
            }
        });

        @if(!Auth::guest())

            $.get("{{route("citas.tiene")}}", function (data) {
            if (data === "true") {
                $("#linkCitas").html('Citas <i class="fa fa-bell" aria-hidden="true"></i> <span class="caret"></span>');
            } else {
                $("#linkCitas").html('Citas <span class="caret"></span>');
            }
        });

        $.get("{{route("perdido.tiene")}}", function (data) {
            if (data === "true") {
                $("#linkPerdido").html('Perdidos <i class="fa fa-bell" aria-hidden="true"></i> <span class="caret"></span>');
            } else {
                $("#linkPerdido").html('Perdidos <span class="caret"></span>');
            }
        });

        @endif
    });
</script>
<script src="/js/common.js"></script>
@yield('scripts')
@yield('partial-scripts')
@yield('info-scripts')


</body>
</html>
