@section("info-scripts")
    <script type="text/javascript">
        $(document).ready(function () {

            $("#listaRanking").hide();
            $("#rankingLoading").show();

                    @if(!empty($mascota))
            var url = "{{route("ranking.tipo",["tipo" => $mascota->tipo_id])}}";
                    @else
            var url = "{{route("ranking.todos")}}";
            @endif

            $.get(url, function (data) {
                var items = '';
                var numerador = 0;
                $.each(data, function (index, value) {
                    numerador += 1;
                    var ref = "{{route("mascota.show",["id"=>-1])}}".replace("-1", value.mascota_id);
                    items = items + '<a href="' + ref + '" class="list-group-item"><strong>'+ numerador +'</strong> <img src="/img/icons/' + value.like_text + '"/> - ' + value.nombre + '</a>';
                });
                $("#listaRanking").html(items);
                $("#listaRanking").show();
                $("#rankingLoading").hide();

            });
        })
    </script>
@endsection
<div class="panel panel-warning">
    <div class="panel-heading">
        Ranking
    </div>
    <div class="panel-body">
        <div id="rankingLoading" class="text-center lead">
            Cargando
            <i class="fa fa-spinner fa-spin fa-4x fa-fw"></i>
        </div>
        <div class="list-group" id="listaRanking">
        </div>
    </div>
</div>