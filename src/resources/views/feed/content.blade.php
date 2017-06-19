@if(empty($feeds))
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <h3 class="text-info">Deberías seguir a alguien para ver algo aquí...</h3>
        </div>
    </div>
@else
    @foreach($feeds as $feed)
        @include('shared.feed')

    @endforeach
@endif