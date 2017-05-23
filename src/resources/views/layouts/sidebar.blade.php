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
        <h4 class="text-center text-info"><a href="{{route('feed')}}">{{$profile->apellido}} {{$profile->nombre}}</a></h4>
        <h5 class="text-center text-primary">Siguiendo: <strong>{{$profile->following}}</strong></h5>
        <h5 class="text-center text-primary">Seguidores: <strong>{{$profile->followers}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <h4 class="text-center text-info"><a href="{{route('mascota')}}">Mascotas:</a></h4>
</div>
@if($profile->mascotas->count())
    <div class="row">

            <div class="profile-usermenu">
                <ul class="nav">
                    @foreach($profile->mascotas as $mascota)
                        <li pet="{{$mascota->id}}">
                            <a  href="{{route('mascota.show',['id' => $mascota->id])}}" >
                                <img src="/img/icons/{{$mascota->raza->tipo->like_text}}">
                                {{$mascota->nombre}}</a>
                        </li>
                    @endforeach
                        <li><a href="{{route("mascota.create")}}"><i class="glyphicon glyphicon-plus"></i> Agregar mascota</a></li>
                </ul>
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
            <a href="{{route("mascota.create")}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Agregar mascota</a>
        </div>
    </div>
@endif