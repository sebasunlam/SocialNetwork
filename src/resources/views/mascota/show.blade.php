@extends('layouts.app')




@section('scripts')

    <script type="text/javascript">
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

            $("#btnFollow").click(function () {
                follow("{{$mascota->id}}")
            });

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
        });
    </script>
@endsection

@section('content')
    <div class="twPc-div">
        <a class="twPc-bg twPc-block"></a>

        <div>
            <div class="twPc-button">
                <!-- Twitter Button | you can get from: https://about.twitter.com/tr/resources/buttons#follow -->

                @if(!$propietario)

                    <button type="button" class="btn btn-success" id="btnFollow"><i class="fa fa-forward"
                                                                                    aria-hidden="true"
                        ></i> Seguir
                    </button>
                @else
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal"><i
                                class="fa fa-commenting-o" aria-hidden="true"></i> Postear
                    </button>
                @endif
                {{--<a href="https://twitter.com/mertskaplan" class="twitter-follow-button" data-show-count="false"--}}
                {{--data-size="large" data-show-screen-name="false" data-dnt="true">Follow @mertskaplan</a>--}}
                {{--<script>!function (d, s, id) {--}}
                {{--var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';--}}
                {{--if (!d.getElementById(id)) {--}}
                {{--js = d.createElement(s);--}}
                {{--js.id = id;--}}
                {{--js.src = p + '://platform.twitter.com/widgets.js';--}}
                {{--fjs.parentNode.insertBefore(js, fjs);--}}
                {{--}--}}
                {{--}(document, 'script', 'twitter-wjs');</script>--}}

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
                        <a href="https://twitter.com/mertskaplan" title="9.840 Tweet">
                            <span class="twPc-StatLabel twPc-block">Posts</span>
                            <span class="twPc-StatValue">{{$posts}}</span>
                        </a>
                    </li>
                    <li class="twPc-ArrangeSizeFit">
                        <a href="https://twitter.com/mertskaplan/followers" title="1.810 Followers">
                            <span class="twPc-StatLabel twPc-block">Seguidores</span>
                            <span class="twPc-StatValue">{{$followers}}</span>
                        </a>
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
@endsection
