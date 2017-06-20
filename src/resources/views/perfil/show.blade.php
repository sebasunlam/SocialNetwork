@extends('layouts.app')


@section('styles')
    <style type="text/css">
        .table-image {
            min-width: 40px;
            min-height: 40px;
            max-width: 40px;
            max-height: 40px;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <p class="text-center text-info">
                @if(!empty($profile->image))
                    <img id="img" src="{{$profile->image}}" alt="" class="img-thumbnail img-responsive">
                @else
                    <img id="img" src="/img/no-avatar.png" alt="Suba una imagen" class="img-thumbnail profile">
                @endif
            </p>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center text-info"><a
                        href="{{route('feed')}}">{{$profile->apellido}} {{$profile->nombre}}</a></h4>
            <h5 class="text-center text-primary">Siguiendo: <strong>{{$profile->following}}</strong></h5>
            <h5 class="text-center text-primary">Seguidores: <strong>{{$profile->followers}}</strong></h5>
        </div>
    </div>
    <div class="row">
        <h4 class="text-center text-info">Mascotas:</h4>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Sexo</th>
                <th>Tipo</th>
                <th>Raza</th>
                <th>En adopcion?</th>
                <th>Buscando pareja?</th>
                <th>Perdido?</th>
                <th></th>
            </tr>
            </thead>
            @foreach($mascotas as $mascota)
                <tr>
                    <td>
                        @if(!empty($mascota->imagen))
                            <img id="img" src="{{$mascota->imagen}}" alt=""
                                 class="img-responsive table-image img-thumbnail">
                        @else
                            <img id="img" src="/img/no-avatar.png" alt="Suba una imagen"
                                 class="img-responsive table-image img-thumbnail">
                        @endif
                    </td>
                    <td>{{$mascota->nombre}}</td>
                    <td>{{$mascota->sexo}}</td>
                    <td>{{$mascota->tipo}}</td>
                    <td>{{$mascota->raza}}</td>

                    @if($mascota->adopcion)
                        <td><span class="text-success"> <i class="fa fa-check"></i></span></td>
                    @else
                        <td><span class="text-danger"> <i class="fa fa-times"></i></span></td>
                    @endif
                    @if($mascota->pareja)
                        <td><span class="text-success"> <i class="fa fa-check"></i></span></td>
                    @else
                        <td><span class="text-danger"> <i class="fa fa-times"></i></span></td>
                    @endif
                    @if($mascota->perdido)
                        <td><span class="text-success"> <i class="fa fa-check"></i></span></td>
                    @else
                        <td><span class="text-danger"> <i class="fa fa-times"></i></span></td>
                    @endif
                    <td><a href="{{route("mascota.show",["id"=>$mascota->id])}}" class="btn btn-primary"><i
                                    class="fa fa-eye"></i> </a></td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
