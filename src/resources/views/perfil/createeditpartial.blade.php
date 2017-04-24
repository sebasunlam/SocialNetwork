{{--@section('styles')--}}
{{--<style>--}}
{{--/* Always set the map height explicitly to define the size of the div--}}
{{--* element that contains the map. */--}}
{{--#map {--}}
{{--min-height: 100px;--}}
{{--max-height: 200px;--}}
{{--height: 100%;--}}
{{--}--}}
{{--</style>--}}
{{--@endsection--}}

@section('scripts')
    <script>
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });
        };
        $(document).ready(function () {
            var map;


            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            };


            $("#provinciaId").change(function () {
                $.get("/departamento/" + $("#provinciaId").val() + "/provincia", function (data) {
                    var deptos = '';
                    for (i = 0; i < data.length; i++) {
                        deptos = deptos + '<option value="' + data[i].id + '">' + data[i].descripcion + '</option>';
                    }
                    $("#departamentoId").html(deptos);
                });
            });

            $("#departamentoId").change(function () {
                $.get("/localidad/" + $("#departamentoId").val() + "/departamento", function (data) {
                    var localidades = '';
                    for (i = 0; i < data.length; i++) {
                        localidades = localidades + '<option value="' + data[i].id + '">' + data[i].descripcion + '</option>';
                    }
                    $("#localidad_id").html(localidades);
                });
            });

            $("#btnSetMarker").click(function () {
                //https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyDzfaxwXl0xql_XMHVs7e2m62Evn8avK3U
                var address = $("#provinciaId option:selected").text() + ',' +
                    $("#departamentoId option:selected").text() + ',' +
                    $("#localidad_id option:selected").text() + ',' + $("#calle").val() + ' ' + $("#numero").val();
                var latLng;
                $.get("https://maps.googleapis.com/maps/api/geocode/json", {
                    address: address,
                    key: "AIzaSyDzfaxwXl0xql_XMHVs7e2m62Evn8avK3U"
                }, function (data) {
                    latLng = data.results[0].geometry.location;
                });
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: address,
                    animation: google.maps.Animation.DROP
                });
                marker.addListener('click', toggleBounce);

                marker.setMap(map);
            });
        });

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzfaxwXl0xql_XMHVs7e2m62Evn8avK3U&callback=initMap"
            async defer></script>
@endsection



<hr>
{{ csrf_field() }}
<h3>Datos Personales</h3>
<div class="row">
    <div class="form-group">
        <label for="nombre" class="col-md-4 control-label">Nombre</label>
        <div class="col-md-6">
            <input type="text" id="nombre" name="nombre" class="col-md-6 form-control"
                   value="{{!empty($perfil) ? $perfil->nombre :'' }}">
            @if ($errors->has('nombre'))
                <span class="help-block">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="apellido" class="col-md-4 control-label">Apellido</label>
        <div class="col-md-6">
            <input type="text" id="apellido" name="apellido" class="form-control"
                   value="{{!empty($perfil) ? $perfil->apellido :'' }}">
            @if ($errors->has('apellido'))
                <span class="help-block">
                    <strong>{{ $errors->first('apellido') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="fechanacimiento" class="col-md-4 control-label">Fecha de Nacimiento</label>
        <div class="col-md-6">
            <input type="text" id="fechanacimiento" name="fechanacimiento" class="form-control"
                   value="{{!empty($perfil) ? $perfil->fechanacimiento :'' }}">
            @if ($errors->has('fechanacimiento'))
                <span class="help-block">
                    <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="telefono" class="col-md-4 control-label">Telefono</label>
        <div class="col-md-6">
            <input type="tel" id="telefono" name="telefono" class="form-control"
                   value="{{!empty($perfil) ? $perfil->telefono :'' }}">
            @if ($errors->has('telefono'))
                <span class="help-block">
                    <strong>{{ $errors->first('telefono') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="sexo_id" class="col-md-4 control-label">Telefono</label>
        <div class="col-md-6">
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
<hr>
<h3>Domicilio</h3>
<div class="row">
    <div class="form-group">
        <label for="provinciaId" class="col-md-4 control-label">Provincia</label>
        <div class="col-md-6">
            <select id="provinciaId" name="provinciaId" class="form-control">
                @foreach( $provincias as $provincia)
                    <option value="{{$provincia->id}}">{{$provincia->descripcion}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="departamentoId" class="col-md-4 control-label">Departamento</label>
        <div class="col-md-6">
            <select id="departamentoId" name="departamentoId" class="form-control">
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="localidad_id" class="col-md-4 control-label">Localidad</label>
        <div class="col-md-6">
            <select id="localidad_id" name="localidad_id" class="form-control">
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="calle" class="col-md-4 control-label">Calle</label>
        <div class="col-md-6">
            <input type="text" id="calle" name="calle" class="col-md-6 form-control"
                   value="{{!empty($perfil) ? $perfil->calle :'' }}">
            @if ($errors->has('calle'))
                <span class="help-block">
                    <strong>{{ $errors->first('calle') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group col-sm-12 col-md-4">
        <label for="numero" class="col-md-4 control-label">Nro</label>
        <div class="col-md-6">
            <input type="number" id="numero" name="numero" class="form-control"
                   value="{{!empty($perfil) ? $perfil->numero :'' }}">
            @if ($errors->has('numero'))
                <span class="help-block">
                    <strong>{{ $errors->first('numero') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <button type="button" id="btnSetMarker" class="btn btn-info"><span
                    class="glyphicon glyphicon-map-marker"></span></button>
    </div>
</div>
<div class="row">
    <div id="map" class="embed-responsive-16by9"></div>
</div>
<div class="row">
    <button class="btn btn-primary" type="submit">Guardar</button>
</div>
