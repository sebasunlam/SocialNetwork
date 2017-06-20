@extends("layouts.app")
@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(".wait").hide();
            $(".check").hide();

            $(".btnPedirAdopcion").click(function () {
                var btn = $(this);

                var spinner = btn.parent(".actionGrabber").find(".wait");
                var check = btn.parent(".actionGrabber").find(".check");
                btn.hide();
                spinner.show();
                var mascotaPiediendoId = $("#mascota_pidiendo_id").val();
                $.ajax({
                    url: "{{route('adopcion.solicitar',['id'=>-1])}}".replace("-1",btn.attr("mascotaId")),
                    type: "POST",
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
        });
    </script>
@endsection
@section("content")
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3>Mascotas en adopcion</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Raza</th>
                    <th>Solicitar</th>
                </tr>
                @foreach($mascotasAdopcion as $mascota)
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
                        <td>{{$mascota->tipo}}</td>
                        <td>{{$mascota->raza}}</td>
                        <td class="actionGrabber">
                            @if($mascota->existe)
                                <i class="fa fa-check" aria-hidden="true"></i>
                            @else
                                <button class="btn btn-danger btnPedirAdopcion" mascotaId="{{$mascota->id}}"
                                        data-toggle="tooltip" data-placement="top" title="Pedir adopción">
                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                </button>
                                <i class="fa fa-spinner fa-spin fa-fw wait"></i>
                                <i class="fa fa-check check" aria-hidden="true"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection