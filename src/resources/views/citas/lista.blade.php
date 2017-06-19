@extends('layouts.app')

@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $(".btnAceptarCita").click(function () {
                var id = $(this).attr("cita");
                aceptaRechaza(id, true)
            });

            $(".btnRechazarCita").click(function () {
                var id = $(this).attr("cita");
                aceptaRechaza(id, false)
            });

            function aceptaRechaza(id, acepta) {
                modal.showPleaseWait();

                $.ajax({
                    url: "{{route('citas.acepta')}}",
                    type: "POST",
                    data: {id: id, acepta: acepta},
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
@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <h1>Citas ofrecidas</h1>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <th>
                <td></td>
                <td>Mi mascota</td>
                <td>Mascota solicitante</td>
                <td>Raza</td>
                <td>Tipo</td>
                <td></td>

                </th>
                @foreach($citas as $cita)
                    <tr>
                        <td>
                            @if(empty($cita->imagenOfrecido))
                                <img alt="{{$cita->nombreOfrecido}}"
                                     src="/img/no-avatar.png"
                                     class="twPc-avatarImg">
                            @else
                                <img alt="{{$cita->nombreOfrecido}}"
                                     src="{{$cita->imagenOfrecido}}"
                                     class="twPc-avatarImg">
                            @endif
                        </td>
                        <td>{{$cita->nombreOfrecido}}</td>
                        <td>{{$cita->nombreBuscando}}</td>
                        <td>{{$cita->raza}}</td>
                        <td>{{$cita->tipo}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btnAceptarCita" cita="{{$cita->id}}">
                                    Aceptar <i class="fa fa-thumbs-o-up"></i>
                                </button>
                                <button type="button"  class="btn btn-danger btnRechazarCita" cita="{{$cita->id}}">
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