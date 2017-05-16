@section('styles')
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
    </style>
@endsection
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        @if(!empty($profile->image))
            <img id="img" src="{{$profile->image}}" alt="" class="img-thumbnail img-responsive">
        @else
            <img id="img" src="/img/no-avatar.png" alt="Suba una imagen" class="img-thumbnail profile">
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <h4 class="text-center text-info">{{$profile->apellido}} {{$profile->nombre}}</h4>
        <h5 class="text-center text-primary">Siguiendo: <strong>{{$profile->following}}</strong></h5>
        <h5 class="text-center text-primary">Seguidores: <strong>{{$profile->followers}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <h4 class="text-center text-info">Mascotas:</h4>
</div>
@if(!empty($mascotas))
    <div class="row">
        <div class="col-md-2">
            <div class="profile-usermenu">
                <ul class="nav">
                    @foreach($mascotas as $profile->mascotas)

                        <li class="active">
                            <a href="#">
                                <img src="/img/icons/{{$mascota->tipo}}">
                                {{$mascota->nombre}} </a>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <h5 class="text-muted">Ups parece que no hay nada por aquí</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-2">
            <a href="/mascota/create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Agregar mascota</a>
        </div>
    </div>
@endif