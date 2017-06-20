@extends("layouts.app")

@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(".btnAceptaAdopcion").click(function () {
                var id = $(this).attr("transferencia");
                aceptaRechaza(id, true)
            });

            $(".btnRechazaAdopcion").click(function () {
                var id = $(this).attr("transferencia");
                aceptaRechaza(id, false)
            });

            function aceptaRechaza(id, aceptada) {
                modal.showPleaseWait();

                $.ajax({
                    url: "{{route('adopcion.acepta',["transferenciaId"=>-1])}}".replace("-1",id),
                    type: "POST",
                    data: {aceptada: aceptada},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })
            }
        })
    </script>
@endsection

@section("content")
    <div class="panel panel-info">
        <div class="panel-heading">
            <h1>Solicitudes de adopcion</h1>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <th>
                <td>Mi mascota</td>
                <td>Solicitante</td>
                <td></td>

                </th>
                @foreach($mascotasSolicitudesAdopcion as $solicitud)
                    <tr>
                        <td>
                            @if(empty($solicitud->imagen))
                                <img alt="{{$solicitud->nombre}}"
                                     src="/img/no-avatar.png"
                                     class="twPc-avatarImg">
                            @else
                                <img alt="{{$solicitud->nombre}}"
                                     src="{{$solicitud->imagen}}"
                                     class="twPc-avatarImg">
                            @endif
                        </td>
                        <td>{{$solicitud->nombre}}</td>
                        <td><a target="_blank" href="{{route("profile.show",['id'=>$solicitud->solicitanteId])}}">{{$solicitud->perfilNombre}}</a></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btnAceptaAdopcion" transferencia="{{$solicitud->transferenciaId}}">
                                    Aceptar <i class="fa fa-thumbs-o-up"></i>
                                </button>
                                <button type="button"  class="btn btn-danger btnRechazaAdopcion" transferencia="{{$solicitud->transferenciaId}}">
                                    Rechazar <i class="fa fa-thumbs-o-down"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection