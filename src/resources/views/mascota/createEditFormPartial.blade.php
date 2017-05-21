@section('styles')
    <style type="text/css">
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

        .petImg {
            min-width: 200px;
            min-height: 200px;
            max-width: 200px;
            max-height: 200px;
        }
    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('li[pet]').removeClass('active');


            function getRazas(tipoId) {
                return $.get("/raza/" + tipoId + "/tipo").done(function (data) {
                    var razas = '<option>Seleccione una raza...</option>';
                    for (i = 0; i < data.length; i++) {
                        razas = razas + '<option value="' + data[i].id + '">' + data[i].descripcion + '</option>';
                    }
                    $("#raza_id").html(razas);
                });
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#petImg').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#photo").change(function () {
                readURL(this);
            });

            $("#tipoId").change(function () {
                modal.showPleaseWait();
                $.when(getRazas($("#tipoId").val())).always(function () {
                    modal.hidePleaseWait();
                });
            });

            @if(!empty($mascota))
            modal.showPleaseWait();
            $.when(getRazas({{$mascota->tipo_id}})).done(function (deptos, localidades) {
                $("#tipoId").val({{$mascota->tipo_id}});
                $("#tamanio_id").val({{$mascota->tamanio_id}});
                $("#sexo_id").val({{$mascota->sexo_id}});
                $("#raza_id").val({{$mascota->raza_id}});

            }).always(function () {
                modal.hidePleaseWait();
            });
            $('li[pet="' + {{$mascota->id}} +'"]').addClass('active')

            @endif
        });

    </script>

@endsection

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-12" align="center">
                <div>
                    @if(!empty($mascota->imagen))
                        <img id="petImg" src="{{$mascota->imagen}}" alt="" class="img-responsive img-thumbnail petImg">
                    @else
                        <img id="petImg" src="/img/no-avatar.png" alt="Suba una imagen"
                             class="img-responsive img-thumbnail petImg">
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" align="center">
                <div>
                    <label class="btn btn-info btn-file">
                        Seleccionar... <input type="file" name="photo" id="photo" hidden> |
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="form-group">
                <label for="nombre" class="col-sm-2 col-md-3 control-label">Nombre</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text" id="nombre" name="nombre" class="form-control"
                           value="{{!empty($mascota) ? $mascota->nombre :'' }}">
                    @if ($errors->has('nombre'))
                        <span class="help-block">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="sexo_id" class="col-sm-2 col-md-3 control-label">Sexo</label>
                <div class="col-sm-10 col-md-9">
                    <select id="sexo_id" name="sexo_id" class="form-control">
                        <option>Seleccione un sexo...</option>
                        @foreach( $sexos as $sexo)
                            <option value="{{$sexo->id}}">{{$sexo->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="tamanio_id" class="col-sm-2 col-md-3 control-label">Tamaño</label>
                <div class="col-sm-10 col-md-9">
                    <select id="tamanio_id" name="tamanio_id" class="form-control">
                        <option>Seleccione un tamaño...</option>
                        @foreach( $tamanios as $tamanio)
                            <option value="{{$tamanio->id}}">{{$tamanio->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="tipoId" class="col-sm-2 col-md-3 control-label">Tipo</label>
                <div class="col-sm-10 col-md-9">
                    <select id="tipoId" name="tipoId" class="form-control">
                        <option>Seleccione un tipo...</option>
                        @foreach( $tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="raza_id" class="col-sm-2 col-md-3 control-label">Raza</label>
                <div class="col-sm-10 col-md-9">
                    <select id="raza_id" name="raza_id" class="form-control">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-8 control-label">Fecha de nacimiento</label>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Día</label>
                <div class="col-sm-2">
                    <input type="number" id="dia_nacimiento" name="dia_nacimiento" class="form-control"
                           value="{{!empty($mascota) ? $mascota->dia_nacimiento :'' }}">
                    @if ($errors->has('dia_nacimiento'))
                        <span class="help-block">
                    <strong>{{ $errors->first('dia_nacimiento') }}</strong>
                </span>
                    @endif
                </div>
                <label class="col-sm-2 control-label">Mes</label>
                <div class="col-sm-2">
                    <input type="number" id="mes_nacimiento" name="mes_nacimiento" class="form-control"
                           value="{{!empty($mascota) ? $mascota->mes_nacimiento :'' }}">
                    @if ($errors->has('mes_nacimiento'))
                        <span class="help-block">
                    <strong>{{ $errors->first('mes_nacimiento') }}</strong>
                </span>
                    @endif
                </div>
                <label class="col-sm-2 control-label">Año</label>
                <div class="col-sm-2">
                    <input type="number" id="anio_nacimiento" name="anio_nacimiento" class="form-control"
                           value="{{!empty($mascota) ? $mascota->anio_nacimiento :'' }}">
                    @if ($errors->has('anio_nacimiento'))
                        <span class="help-block">
                    <strong>{{ $errors->first('anio_nacimiento') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">
    <div class="col-sm-offset-9 col-sm-3">
        <button class="btn btn-primary" type="submit">Guardar</button>
    </div>
</div>