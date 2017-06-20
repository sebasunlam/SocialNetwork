@extends('layouts.app')




@section('scripts')

    <script type="text/javascript">
        var map;
        var lat;
        var lng;
        var marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8,
                disableDefaultUI: true,
                draggable: true
            });


            google.maps.event.addListener(map, 'click', function (event) {
                lat = event.latLng.lat();
                lng = event.latLng.lng();
                placeMarker(event.latLng);
            });

            function placeMarker(location) {
                if (marker != undefined)
                    marker.setMap(null);
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    animation: google.maps.Animation.DROP
                });

            }
        }
        $(document).ready(function () {
            $("#imageData").hide();
            $("#videoData").hide();

            function follow(mascotaId) {
                modal.showPleaseWait();
                $.ajax({
                    url: "{{route('profile.follow')}}",
                    type: "POST",
                    data: {mascota_id: mascotaId},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            }

            function unfollow(mascotaId) {
                modal.showPleaseWait();
                $.ajax({
                    url: "{{route('profile.unfollow')}}",
                    type: "POST",
                    data: {mascota_id: mascotaId},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            }

            function buscarPaerja() {
                modal.showPleaseWait();
                $.ajax({
                    url: "{{route('citas.buscando',["id"=>$mascota->id])}}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            }

            function dejarDeBuscar() {
                modal.showPleaseWait();
                $.ajax({
                    url: "{{route('citas.dejardebuscar',["id"=>$mascota->id])}}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            }

            @if($mascota->buscandoPareja)
            $("#btnTooglePareja").click(function () {
                dejarDeBuscar();
            });
            @else
            $("#btnTooglePareja").click(function () {
                buscarPaerja();
            });
            @endif

            $("#btnFollow").click(function () {
                follow("{{$mascota->id}}");
            });

            $("#btnUnFollow").click(function () {
                unfollow("{{$mascota->id}}");
            })

            $(".radio").click(function () {
                var value = $(this).find('input:radio').prop('value');
                switch (value) {
                    case 'video':
                        $("#imageData").hide();
                        $("#videoData").show();
                        break;
                    case 'image':
                        $("#imageData").show();
                        $("#videoData").hide();
                        break;

                    default:
                        $("#imageData").hide();
                        $("#videoData").hide();
                }
            });

            function getId(url) {
                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                var match = url.match(regExp);

                if (match && match[2].length == 11) {
                    return match[2];
                } else {
                    return 'error';
                }
            }

            $("#videoUrl").change(function () {
                var videoId = getId($("#videoUrl").val());
                $("#videoUrl").val("https:///www.youtube.com/embed/" + videoId);
            });

            @if($mascota->perdido)
             $("#btntoogleperdido").click(function () {
                modal.showPleaseWait();
                $.ajax({
                    url: "{{route('perdido.desmarcar',["id"=>$mascota->id])}}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            });
            @else
            $("#btnTooglePerdido").click(function () {
                $("#mapModal").modal("show");
            });

            $("#mapModal").on("shown.bs.modal", function () {
                google.maps.event.trigger(map, "resize");
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        map.setCenter(pos);
                    });
                }
            });



            $("#btnGuardarPerdido").click(function () {
                modal.showPleaseWait();
                $.ajax({
                    url: "{{route('perdido.marcar',["id"=>$mascota->id])}}",
                    type: "POST",
                    data:{
                        lat: lat,
                        long:lng
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            });





            @endif
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwsdz2QoD3Bk4JhQNShw1GZ2cTsuY61vE&callback=initMap"
            async defer></script>
@endsection

@section('content')
    <div class="twPc-div">
        <a class="twPc-bg twPc-block"></a>

        <div>
            <div class="twPc-button">

                @if(!$propietario)
                    @if(!$siguiendo)
                        <button type="button" class="btn btn-success" id="btnFollow"><i class="fa fa-forward"
                                                                                        aria-hidden="true"></i> Seguir
                        </button>
                    @else
                        <button type="button" class="btn btn-success" id="btnUnFollow"><i class="fa fa-backward"
                                                                                          aria-hidden="true"></i> Dejar
                            de seguir
                        </button>
                    @endif

                @else

                    <button class="btn btn-warning" type="button" id="btnTooglePerdido">
                        @if($mascota->perdido)
                            Lo encontre!! <i class="fa fa-search-minus" aria-hidden="true"></i>
                        @else
                            Perdido <i class="fa fa-search-plus" aria-hidden="true"></i>
                        @endif
                    </button>

                    <button class="btn btn-danger" type="button" id="btnTooglePareja">
                        @if($mascota->buscandoPareja)
                            Dejar de buscar <i class="fa fa-heart-o" aria-hidden="true"></i>
                        @else
                            Buscar pareja <i class="fa fa-heart" aria-hidden="true"></i>
                        @endif
                    </button>
                    <a href="{{route("mascota.pdf",["id"=>$mascota->id])}}" class="btn btn-info">PDF <i
                                class="fa fa-download"></i> </a>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal">
                        <i
                                class="fa fa-commenting-o" aria-hidden="true"></i> Postear
                    </button>
                @endif

            </div>

            <a title="{{$mascota->nombre}}" href="{{route('mascota.show',['id'=>$mascota->id])}}"
               class="twPc-avatarLink">
                @if(empty($mascota->imagen))
                    <img alt="{{$mascota->nombre}}"
                         src="/img/no-avatar.png"
                         class="twPc-avatarImg">
                @else
                    <img alt="{{$mascota->nombre}}"
                         src="{{$mascota->imagen}}"
                         class="twPc-avatarImg">
                @endif

            </a>

            <div class="twPc-divUser">
                <div class="twPc-divName">
                    <a href="{{route('mascota.show',['id'=>$mascota->id])}}">{{$mascota->nombre}}</a>
                </div>
                <span>
			</span>
            </div>

            <div class="twPc-divStats">
                <ul class="twPc-Arrange">
                    <li class="twPc-ArrangeSizeFit">
                        <a href="$" title="{{$posts}} posts">
                            <span class="twPc-StatLabel twPc-block">Posts</span>
                            <span class="twPc-StatValue">{{$posts}}</span>
                        </a>
                    </li>
                    <li class="twPc-ArrangeSizeFit">
                        <a href="#" title="{{$followers}} seguidores">
                            <span class="twPc-StatLabel twPc-block">Seguidores</span>
                            <span class="twPc-StatValue">{{$followers}}</span>
                        </a>
                    </li>
                    <li>
                        <div class="visible-print text-center">
                            {{--<img src="data:image/png;base64,{{base64_encode(QrCode::format('png'))->generate(route("mascota.show",["id"=>$mascota->id]))}}"/>--}}

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    @if(empty($feeds))
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h3 class="text-info">Realiza algun post para ver algo aquí...</h3>
            </div>
        </div>
    @else
        @foreach($feeds as $feed)
            @include('shared.feed')
        @endforeach
    @endif
    @include('mascota.post')
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
                    <button type="button" class="btn btn-primary" id="btnGuardarPerdido">Guardar</button>
                </div>
            </div>

        </div>
    </div>

@endsection
