@if(empty($feeds))
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <h3 class="text-info">Deberías seguir a alguien para ver algo aquí...</h3>
        </div>
    </div>
@else
    @foreach($feeds as $feed)
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h3 class="text-info">{{$feed->petName}}
                    <small>{{$feed->timeStamp}}</small>
                </h3>


                @if($feed->type == 'media')
                    @if($feed->mediaType == 'video')
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{$feed->url}}"></iframe>
                        </div>
                    @else
                        <div class="embed-responsive embed-responsive-16by9">
                            <img class="img-responsive img-rounded" src="{{$feed->image}}"></img>
                        </div>
                    @endif
                @endif
                <p class="text-muted">
                    {{$feed->content}}
                </p>
            </div>
        </div>
        @foreach($feed->comments as $comment)
            <div class="row">
                <p class="text-muted">
                    {{$comment}}
                </p>
            </div>
        @endforeach
        <div class="row">
            <input type="hidden" id="postId" value="{{$feed->id}}">
            <button type="button" class="btn btn-success col-md-1" id="btnLike">
                <img class="/img/icons/{{$feed->icon}}">{{$feed->animalUpText}}
            </button>
            <button type="button" class="btn btn-danger col-md-1" id="btnDisLike">
                <img class="/img/icons/{{$feed->icon}}">{{$feed->animalDowText}}</button>
            </button>
            <input class="form-control col-md-10" id="comment" placeholder="Di lo que piensas..." type="text">
        </div>
    @endforeach
@endif