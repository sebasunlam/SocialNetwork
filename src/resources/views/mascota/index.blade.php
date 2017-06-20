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
    <div class="container-fluid">
        <table class="table table-striped table-condensed">
            <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Sexo</th>
                <th>Tipo</th>
                <th>Raza</th>
                <th>Tamaño</th>
                <th>Fecha de nacimiento</th>
                <th>En adopcion?</th>
                <th>Buscando pareja?</th>
                <th>Perdido?</th>
                <th style="width:20%"></th>
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
                    <td>{{$mascota->tamanio}}</td>
                    <td>{{$mascota->nacimiento}}</td>
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
                    <td>
                        <div class="btn-group" role="group" aria-label="...">
                            <a class="btn btn-success" href="{{route('mascota.edit',['id'=>$mascota->id])}}"><span
                                        class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top"
                                        title="Editar"></span></a>
                            <a class="btn btn-info" href="{{route('mascota.show',['id'=>$mascota->id])}}"><span
                                        class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top"
                                        title="Ver"></span></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection