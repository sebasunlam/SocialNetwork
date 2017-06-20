@extends("layouts.app")
@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(".showImage").click(function () {
                $('#imagenEncontrado').attr('src', $(this).attr("image"));
                $("#imageModal").modal("show");
            });

            function acept(id, acepta) {
                modal.showPleaseWait();
                $.ajax({
                    url: "{{route('perdido.acepta',["id"=>-1])}}".replace("-1", id),
                    type: "POST",
                    data: {
                        acepta: acepta
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            }

            $(".acceptEncotrado").click(function () {

                acept($(this).attr("encontradoId"), true);
            });

            $(".rejectEncontrado").click(function () {

                acept($(this).attr("encontradoId"), false);
            });

        });
    </script>
@endsection
@section("content")
    <div class="panel panel-warning">
        <div class="panel-heading">
            Mascotas perdidas
        </div>
        <div class="panel-body">
            @foreach($mascotasEncontradas as $mascota)
                <div class="col-sm-6 col-md-6">
                    <div class="thumbnail">
                        <img src="{{$mascota->imagen}}" alt="...">
                        <div class="caption">
                            <div class="text-center">
                                <h3>{{$mascota->nombre}}</h3>
                            </div>
                            <hr>
                            @foreach($mascota->encontrados as $encontrado)
                                <div class="row">
                                    <div class="col-md-offset-1">
                                        Contacto: <strong>{{$encontrado->contacto}}</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1">
                                        <div class="btn-group">
                                            <button class="btn btn-warning showImage"
                                                    image="{{$encontrado->imagen}}"
                                                    type="button"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Ver imagen"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-success acceptEncotrado" type="button"
                                                    encontradoId="{{$encontrado->id}}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Aceptar"><i class="fa fa-thumbs-up"></i>
                                            </button>
                                            <button class="btn btn-danger rejectEncontrado" type="button"
                                                    encontradoId="{{$encontrado->id}}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Rechazar"><i class="fa fa-thumbs-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="imageModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="imageModalHeader">Imagen</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <img src="" id="imagenEncontrado">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
@endsection