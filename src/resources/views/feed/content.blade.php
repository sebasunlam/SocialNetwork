@if(empty($feeds))
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <h3 class="text-info">Deberías seguir a alguien para ver algo aquí...</h3>
        </div>
    </div>
@else
    @foreach($feeds as $feed)
        @include('shared.feed')
        {{--<div class="panel panel-info">--}}
            {{--<div class="panel-body">--}}


                {{--<div class="row">--}}
                    {{--<div class="col-md-offset-1 col-md-10">--}}
                        {{--<h3 class="text-info">{{$feed->petName}}--}}
                            {{--<small>{{$feed->timeStamp}}</small>--}}
                        {{--</h3>--}}
                        {{--@if($feed->type == 'media')--}}
                            {{--@if($feed->mediaType == 'video')--}}
                                {{--<div class="embed-responsive embed-responsive-16by9">--}}
                                    {{--<iframe width="420" height="315"--}}
                                            {{--src="{{$feed->url}}">--}}
                                    {{--</iframe>--}}
                                {{--</div>--}}
                            {{--@else--}}
                                {{--<div class="embed-responsive embed-responsive-16by9">--}}
                                    {{--<img class="img-responsive img-rounded" src="{{$feed->image}}">--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--@endif--}}
                        {{--<p class="text-muted">--}}
                            {{--{{$feed->content}}--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
            {{--<div class="panel-footer">--}}
                {{--@foreach($feed->comments as $comment)--}}
                    {{--<div class="row">--}}
                        {{--<div class="panel">--}}
                            {{--<div class="panel-body">--}}
                                {{--<p class="text-muted">--}}
                                    {{--{{$comment}}--}}
                                {{--</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
                {{--<hr>--}}

                {{--<div class="row">--}}
                    {{--<input type="hidden" id="postId" value="{{$feed->id}}">--}}
                    {{--<div class="col-md-10">--}}
                        {{--<input class="form-control " id="comment" placeholder="Di lo que piensas..."--}}
                               {{--type="text">--}}
                    {{--</div>--}}
                    {{--<div class="btn-group col-md-2" role="group">--}}
                        {{--<button type="button" class="btn btn-success" id="btnLike">--}}
                            {{--<img class="/img/icons/{{$feed->icon}}"> <span--}}
                                    {{--class="glyphicon glyphicon-thumbs-up"></span>--}}
                        {{--</button>--}}
                        {{--<button type="button" class="btn btn-danger" id="btnDisLike">--}}
                            {{--<img class="/img/icons/{{$feed->icon}}"><span--}}
                                    {{--class="glyphicon glyphicon-thumbs-down"></span>--}}
                        {{--</button>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    @endforeach
@endif