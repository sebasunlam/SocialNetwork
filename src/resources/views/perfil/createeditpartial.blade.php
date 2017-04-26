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
    </style>
@endsection
@section('scripts')
    <script>

        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8,
                disableDefaultUI: true,
                draggable: false
            });
        }
        $(document).ready(function () {

            var marker;

            $('.input-group.date').datepicker({
                format: "yyyy-mm-dd",
                language: "es"
            });

            function getLocalidades(departamentoId) {
                return $.get("/localidad/" + departamentoId + "/departamento").done(function (data) {
                    var localidades = '<option>Seleccione una localidad...</option>';
                    for (i = 0; i < data.length; i++) {
                        localidades = localidades + '<option value="' + data[i].id + '">' + data[i].descripcion + '</option>';
                    }
                    $("#localidad_id").html(localidades);
                });
            }


            function getDepartamentos(provinciaId) {

                return $.get("/departamento/" + provinciaId + "/provincia").done(function (data) {
                    var deptos = '<option>Seleccione un departamento...</option>';
                    ;
                    for (i = 0; i < data.length; i++) {
                        deptos = deptos + '<option value="' + data[i].id + '">' + data[i].descripcion + '</option>';
                    }
                    $("#departamentoId").html(deptos);
                });
            }


            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            };


            function setMarker() {

                if (marker != undefined)
                    marker.setMap(null);

                var address = $("#provinciaId option:selected").text() + ',' +
                    $("#departamentoId option:selected").text() + ',' +
                    $("#localidad_id option:selected").text() + ',' + $("#calle").val() + ' ' + $("#numero").val();
                var latLng;
                return $.get("https://maps.googleapis.com/maps/api/geocode/json", {
                    address: address,
                    key: "AIzaSyDzfaxwXl0xql_XMHVs7e2m62Evn8avK3U"
                }).done(function (data) {
                    if (data.status == 'OK') {
                        latLng = new google.maps.LatLng(data.results[0].geometry.location.lat, data.results[0].geometry.location.lng);

                        marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            title: address,
                            animation: google.maps.Animation.DROP
                        });

                        marker.addListener('click', toggleBounce);

                        map.setZoom(13);
                        map.setCenter(latLng);
                        marker.setMap(map);

                        $("#lat").val(data.results[0].geometry.location.lat);
                        $("#long").val(data.results[0].geometry.location.lng);
                    } else {
                        modal.hidePleaseWait();
                        toogleWarinngModal('<h3>Google no encontro su dirección</h3>', 'Opssss...', 'Aceptar');

                    }


                })
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#photo").change(function () {
                readURL(this);
            });


            $("#provinciaId").change(function () {
                modal.showPleaseWait();
                $.when(getDepartamentos($("#provinciaId").val())).always(function () {
                    modal.hidePleaseWait();
                });
            });

            $("#departamentoId").change(function () {
                modal.showPleaseWait();
                $.when(getLocalidades($("#departamentoId").val())).always(function () {
                    modal.hidePleaseWait();
                })
            });

            $("#btnSetMarker").click(function (e) {
                e.preventDefault();
                modal.showPleaseWait();
                $.when(setMarker()).always(function () {
                    modal.hidePleaseWait();
                });

            });

            @if(!empty($domicilio))
            modal.showPleaseWait();
            $.when(getDepartamentos({{$provincia_id}}), getLocalidades({{$departamento_id}})).done(function (deptos, localidades) {
                $("#provinciaId").val({{$provincia_id}});
                $("#localidad_id").val({{$domicilio->localidad_id}});
                $("#departamentoId").val({{$departamento_id}});
                $.when(setMarker()).always(function () {
                    modal.hidePleaseWait();
                });

            }).always(function () {
                modal.hidePleaseWait();
            });

            map.setCenter(new google.maps.LatLng({{$domicilio->long}},{{$domicilio->long}}));
            @else

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    map.setCenter(pos);
                });
            }

            @endif
        });

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzfaxwXl0xql_XMHVs7e2m62Evn8avK3U&callback=initMap"
            async defer></script>
@endsection



{{ csrf_field() }}
<input type="hidden" id="lat" name="lat" value="{{!empty($domicilio) ? $domicilio->lat :'' }}">
<input type="hidden" id="long" name="long" value="{{!empty($domicilio) ? $domicilio->long :'' }}">

<div class="row">
    <div class="col-sm-12" align="center">
        <div>
            @if(!empty($imagen))
                <img id="img" src="{{$imagen}}" alt="" class="img-thumbnail profile">
            @else
                <img id="img" src="/img/no-avatar.png" alt="Suba una imagen" class="img-thumbnail profile">
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
<hr>
<div class="row">
    <div class="col-sm-12 col-md-5">
        <h3>Datos Personales</h3>
        <div class="row">
            <div class="form-group">
                <label for="nombre" class="col-sm-2 col-md-3 control-label">Nombre</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text" id="nombre" name="nombre" class="form-control"
                           value="{{!empty($perfil) ? $perfil->nombre :'' }}">
                    @if ($errors->has('nombre'))
                        <span class="help-block">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="apellido" class="col-sm-2 col-md-3 control-label">Apellido</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text" id="apellido" name="apellido" class="form-control"
                           value="{{!empty($perfil) ? $perfil->apellido :'' }}">
                    @if ($errors->has('apellido'))
                        <span class="help-block">
                    <strong>{{ $errors->first('apellido') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="fechanacimiento" class="col-sm-2 col-md-3 control-label">Fecha de Nacimiento</label>
                <div class="col-sm-10 col-md-9">
                    <div class="input-group date">
                        <input type="text" id="fechanacimiento" name="fechanacimiento" class="form-control"
                               value="{{!empty($perfil) ? $perfil->fechanacimiento :'' }}">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    @if ($errors->has('fechanacimiento'))
                        <span class="help-block">
                    <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="telefono" class="col-sm-2 col-md-3 control-label">Telefono</label>
                <div class="col-sm-10 col-md-9">
                    <input type="tel" id="telefono" name="telefono" class="form-control"
                           value="{{!empty($perfil) ? $perfil->telefono :'' }}">
                    @if ($errors->has('telefono'))
                        <span class="help-block">
                    <strong>{{ $errors->first('telefono') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="sexo_id" class="col-sm-2 col-md-3 control-label">Telefono</label>
                <div class="col-sm-10 col-md-9">
                    <select id="sexo_id" name="sexo_id" class="form-control">
                        @foreach( $sexos as $sexo)
                            <option value="{{$sexo->id}}" {{!empty($perfil) && $perfil->sexo_id == $sexo->id ? 'selected="selected"' :'' }}>{{$sexo->descripcion}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('telefono'))
                        <span class="help-block">
                    <strong>{{ $errors->first('telefono') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-offset-1 col-md-5">
        <h3>Domicilio</h3>
        <div class="row">
            <div class="form-group">
                <label for="provinciaId" class="col-sm-2 col-md-3 control-label">Provincia</label>
                <div class="col-sm-10 col-md-9">
                    <select id="provinciaId" name="provinciaId" class="form-control">
                        <option>Seleccione una provincia...</option>
                        @foreach( $provincias as $provincia)
                            <option value="{{$provincia->id}}">{{$provincia->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="departamentoId" class="col-sm-2 col-md-3 control-label">Departamento</label>
                <div class="col-sm-10 col-md-9">
                    <select id="departamentoId" name="departamentoId" class="form-control">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="localidad_id" class="col-sm-2 col-md-3 control-label">Localidad</label>
                <div class="col-sm-10 col-md-9">
                    <select id="localidad_id" name="localidad_id" class="form-control">
                    </select>
                </div>
            </div>
            <div class="row input-group">

                <label for="calle" class="col-sm-2 col-md-2 control-label">Calle</label>
                <div class="col-sm-10 col-md-5">
                    <input type="text" id="calle" name="calle" class="form-control"
                           value="{{!empty($domicilio) ? $domicilio->calle :'' }}">
                    @if ($errors->has('calle'))
                        <span class="help-block">
                    <strong>{{ $errors->first('calle') }}</strong>
                </span>
                    @endif
                </div>
                <label for="numero" class="col-sm-2 col-md-2 control-label">Nro</label>
                <div class="col-sm-9 col-md-2">
                    <input type="text" id="numero" name="numero" class="form-control"
                           value="{{!empty($domicilio) ? $domicilio->numero :'' }}">
                    @if ($errors->has('numero'))
                        <span class="help-block"><strong>{{ $errors->first('numero') }}</strong></span>
                    @endif
                </div>
                <div class="col-sm-1">
                    <button type="button" id="btnSetMarker" class="btn btn-info"><span
                                class="glyphicon glyphicon-map-marker"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel">
            <div class="panel-body">
                <div id="map" class="embed-responsive-16by9"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-offset-9 col-sm-3">
        <button class="btn btn-primary" type="submit">Guardar</button>
    </div>
</div>

