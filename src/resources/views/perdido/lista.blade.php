@extends("layouts.app")
@section("scripts")
    <script type="text/javascript">
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

            function setMarker(lat, long) {

                if (marker != undefined)
                    marker.setMap(null);

                latLng = new google.maps.LatLng(lat, long);

                marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    animation: google.maps.Animation.DROP
                });

                map.setZoom(13);
                map.setCenter(latLng);
                marker.setMap(map);

            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#imgPerdido').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#photo").change(function () {
                readURL(this);
            });

            var lat;
            var lng;
            $(".showMap").click(function () {
                lat = $(this).attr("lat");
                lng = $(this).attr("long");
                $("#mapModal").modal("show");
            });

            $("#mapModal").on("shown.bs.modal", function () {
                google.maps.event.trigger(map, "resize");
                setMarker(lat, lng);
                map.setCenter(new google.maps.LatLng(lat, lng));
            });

            $(".showForm").click(function () {
                $("#perdido_id").val($(this).attr("perdidoId"));
                $("#foundModal").modal("show");
            })


        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwh1Iw_UoMk5RGKEDc-6YVLsK6XCOUvxw&callback=initMap"
            async defer></script>
@endsection
@section("content")
    <div class="panel panel-warning">
        <div class="panel-heading">
            Mascotas perdidas
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Raza</th>
                    <th>Ubicacion</th>
                    <th>Reportar encotrada</th>
                </tr>
                @foreach($mascotas as $mascota)
                    <tr>
                        <td>{{$mascota->nombre}}</td>
                        <td>{{$mascota->tipo}}</td>
                        <td>{{$mascota->raza}}</td>
                        <td>
                            <button class="btn btn-warning showMap" lat="{{$mascota->lat}}" long="{{$mascota->long}}"
                                    type="button"><i class="fa fa-map-marker"></i></button>
                        </td>
                        <td>
                            <button class="btn btn-primary showForm" type="button" perdidoId="{{$mascota->perdidoId}}">
                                <i class="fa fa-search"></i></button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="modal fade" id="mapModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="mapModalHeader">Lugar</h4>
                </div>
                <div class="modal-body">
                    <div id="map" class="embed-responsive-16by9"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="foundModal" role="dialog">
        <div class="modal-dialog">
            <form action="{{route("perdido.encontrado")}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="foundModalHeader">Lugar</h4>
                </div>
                <div class="modal-body">

                        {{ csrf_field() }}
                        <input type="hidden" id="perdido_id" value="" name="perdido_id">
                        <div class="row">
                            <div class="col-sm-12" align="center">
                                <div>
                                    <img id="imgPerdido" src="/img/noimage.jpg" alt="Suba una imagen"
                                         class="img-thumbnail profile">
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
                        <div class="form-group">
                            <label class="label col-md-2">Contacto</label>
                            <input type="text" placeholder="Indique un mail o numero de telefono" class="form-control col-md-6"
                                   name="contacto" id="contacto">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar"> Guardar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
