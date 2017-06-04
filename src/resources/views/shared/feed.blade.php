@section('partial-scripts')
    <script type="text/javascript">
        $(document).ready(function () {


            function comment(postId, coment, like) {
                modal.showPleaseWait();

                $.ajax({
                    url: "{{route('profile.comment')}}",
                    type: "POST",
                    data: {post_id: postId, coment: coment, like: like, mascota_id: "{{$feed->petId}}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function () {
                    location.reload();
                }).always(function () {
                    modal.hidePleaseWait();
                })


            }

            $(".btnLike").click(function () {
                var postId = $(this).attr("postId");
                comment(postId, $("#comment").val(), true);
            })
            $(".btnDisLike").click(function () {
                var postId = $(this).attr("postId");
                comment(postId, $("#comment").val(), true);
            })
        });
    </script>
@endsection

@section("partial-styles")
    <style type="text/css">
        hr.endcomments {
            border-top: 1px solid #8c8b8b;
        }
    </style>
@endsection

<div class="panel panel-info">
    <div class="panel-heading">
        <a title="{{$feed->petName}}" href="{{route('mascota.show',['id'=>$feed->petId])}}"
           class="twPc-avatarLink">
            @if(empty($feed->petImage))
                <img alt="{{$feed->petName}}"
                     src="/img/no-avatar.png"
                     class="twPc-avatarImg">
            @else
                <img alt="{{$feed->petName}}"
                     src="{{$feed->petImage}}"
                     class="twPc-avatarImg">
            @endif

        </a>
        <a title="{{$feed->petName}}" href="{{route('mascota.show',['id'=>$feed->petId])}}">
            <h4 class="text-info">{{$feed->petName}}
                <small>publico el {{$feed->timeStamp}}</small>
            </h4>
        </a>


    </div>
    <div class="panel-body">


        <div class="row">
            <div class="col-md-offset-1 col-md-10">


                @if($feed->type == 'media')
                    @if($feed->mediaType == 'video')
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{$feed->url}}"></iframe>
                        </div>
                    @else
                        <img class="img-responsive img-rounded" src="{{$feed->image}}">
                    @endif
                @endif
                <p class="text-muted lead">
                    {{$feed->content}}
                </p>
            </div>
        </div>

    </div>

    <div class="panel-footer">
        @if($feed->commentsCounter == 0)
            <div class="text-muted text-center">
                <h5>Este post no tiene comentarios</h5>
            </div>
        @else
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="list-group">
                        @foreach($feed->comments as $comment)

                            <div class="list-group-item">

                                    <a href="{{route('profile.show',['id'=>$comment->profileId])}}">
                                        <h5 class="text-info">
                                            @if(empty($comment->profileImage))
                                                <img alt="{{$comment->profileName}}"
                                                     src="/img/no-avatar.png"
                                                     class="twPc-avatarImgComments">
                                            @else
                                                <img alt="{{$comment->profileName}}"
                                                     src="{{$comment->profileImage}}"
                                                     class="twPc-avatarImgComments">
                                            @endif
                                            {{$comment->profileName}}
                                            <small> publicado el {{$comment->timeStamp}}</small>
                                            @if(empty($comment->comment))
                                                <img src="/img/icons/{{$feed->icon}}">
                                                @if($comment->like)
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                @else
                                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                                @endif
                                            @endif
                                        </h5>
                                    </a>

                                @if(!empty($comment->comment))
                                    <p class="text-muted">
                                        {{$comment->comment}}
                                        <img src="/img/icons/{{$feed->icon}}">
                                        @if($comment->like)
                                            <span class="glyphicon glyphicon-thumbs-up"></span>
                                        @else
                                            <span class="glyphicon glyphicon-thumbs-down"></span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($feed->canComment)
            <hr class="endcomments">
            <div class="row">
                <input type="hidden" id="postId" value="{{$feed->id}}">
                <div class="col-md-9">
                    <input class="form-control " id="comment" placeholder="Di lo que piensas..."
                           type="text">
                </div>
                <div class="btn-group col-md-3" role="group">
                    <button type="button" class="btn btn-success btnLike" postId="{{$feed->id}}">
                        <img src="/img/icons/{{$feed->icon}}"> <span class="glyphicon glyphicon-thumbs-up"></span>
                    </button>
                    <button type="button" class="btn btn-danger btnDisLike" postId="{{$feed->id}}">
                        <img src="/img/icons/{{$feed->icon}}"> <span class="glyphicon glyphicon-thumbs-down"></span>
                    </button>
                </div>

            </div>
        @endif
    </div>
</div>