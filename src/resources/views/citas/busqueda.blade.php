@extends('layouts.app')
@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {

            function getRazas(mascotaId) {
                return $.get("/mascota/" + mascotaId + "/tipo").done(function (tipo) {
                    return $.get("/raza/" + tipo + "/tipo").done(function (data) {
                        var razas = '<option value="">Seleccione una raza...</option>';
                        for (i = 0; i < data.length; i++) {
                            razas = razas + '<option value="' + data[i].id + '">' + data[i].descripcion + '</option>';
                        }
                        $("#raza_id").html(razas);

                    });
                });
            }

            $("#mascota_pidiendo_id").change(function () {
                modal.showPleaseWait();
                $.when(getRazas($("#mascota_pidiendo_id").val())).always(function () {
                    modal.hidePleaseWait();
                });
            });

            $(".wait").hide();
            $(".check").hide();

            $(".btnPedirCita").click(function () {
                var btn = $(this);
                var spinner = btn.parent(".actionGrabber").find(".wait");
                var check = btn.parent(".actionGrabber").find(".check");
                btn.hide();
                spinner.show();
                var mascotaPiediendoId = $("#mascota_pidiendo_id").val();
                $.ajax({
                    url: "{{route('citas.solicitar')}}",
                    type: "POST",
                    data: {
                        mascota_pidiendo_id: mascotaPiediendoId,
                        mascota_buscando_id: btn.attr("mascotaId")
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function () {
                        spinner.hide();
                        btn.show();
                    }, success: function () {
                        spinner.hide();
                        check.show();
                    }
                });
            });

            @if(!empty($model))
            $("#mascota_pidiendo_id").val({{$model->mascota_pidiendo_id}});

            $.when(getRazas({{$model->mascota_pidiendo_id}})).done(function () {
                $("#tamanio_id").val({{$model->tamanio_id}});
            });

            $("#raza_id").val({{$model->raza_id}});
            @endif
        });
    </script>
@endsection
@section("content")

    <div class="panel panel-info">
        <div class="panel-heading">Parámetros de busqueda</div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{route('citas.find')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="mascota_pidiendo_id" class="col-sm-2 col-md-3 control-label">Mascota que
                        busca</label>
                    <div class="col-sm-10 col-md-9">
                        <select id="mascota_pidiendo_id" name="mascota_pidiendo_id" class="form-control">
                            <option value="">Seleccione una mascota...</option>
                            @foreach( $misMascotas as $mascota)
                                <option value="{{$mascota->id}}"><img
                                            src="/img/icons/{{$mascota->like_text}}"/> {{$mascota->nombre}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('mascota_pidiendo_id'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('mascota_pidiendo_id') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="raza_id" class="col-sm-2 col-md-3 control-label">Raza</label>
                    <div class="col-sm-10 col-md-9">
                        <select id="raza_id" name="raza_id" class="form-control">
                        </select>
                        @if ($errors->has('raza_id'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('telefono') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="tamanio_id" class="col-sm-2 col-md-3 control-label">Tamaño</label>
                    <div class="col-sm-10 col-md-9">
                        <select id="tamanio_id" name="tamanio_id" class="form-control">
                            <option value="">Seleccione un tamaño...</option>
                            @foreach( $tamanios as $tamanio)
                                <option value="{{$tamanio->id}}">{{$tamanio->descripcion}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('tamanio_id'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('telefono') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                @if(!empty($multipleErrors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($multipleErrors as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    @if(!empty($mascotasCitas))

        <div class="panel panel-default">
            <table class="table table-striped">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Raza</th>
                    <th>Provincia</th>
                    <th>Departamento</th>
                    <th>Localidad</th>
                    <th></th>
                </tr>
                @foreach($mascotasCitas as $mascota)
                    <tr>
                        <td>
                            @if(empty($mascota->imagen))
                                <img alt="{{$mascota->nombre}}"
                                     src="/img/no-avatar.png"
                                     class="twPc-avatarImg">
                            @else
                                <img alt="{{$mascota->nombre}}"
                                     src="{{$mascota->imagen}}"
                                     class="twPc-avatarImg">
                            @endif
                        </td>
                        <td>{{$mascota->nombre}}</td>
                        <td>{{$mascota->raza}}</td>
                        <td>{{$mascota->provincia}}</td>
                        <td>{{$mascota->departamento}}</td>
                        <td>{{$mascota->localidad}}</td>
                        <td class="actionGrabber">
                            @if($mascota->existeCita)
                                <i class="fa fa-check" aria-hidden="true"></i>
                            @else
                                <button class="btn btn-danger btnPedirCita" mascotaId="{{$mascota->id}}"
                                        data-toggle="tooltip" data-placement="top" title="Pedir cita">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </button>
                                <i class="fa fa-spinner fa-spin fa-fw wait"></i>
                                <i class="fa fa-check check" aria-hidden="true"></i>
                            @endif
                        </td>
                    </tr>

                @endforeach

            </table>
        </div>

    @endif
@endsection