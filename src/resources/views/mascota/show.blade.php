@extends('layouts.app')

@section('styles')
    <style type="text/css">
        .twPc-div {
            background: #fff none repeat scroll 0 0;
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            height: 200px;

        }

        .twPc-bg {
            background-image: url("https://pbs.twimg.com/profile_banners/50988711/1384539792/600x200");
            background-position: 0 50%;
            background-size: 100% auto;
            border-bottom: 1px solid #e1e8ed;
            border-radius: 4px 4px 0 0;
            height: 95px;
            width: 100%;
        }

        .twPc-block {
            display: block !important;
        }

        .twPc-button {
            margin: -35px -10px 0;
            text-align: right;
            width: 100%;
        }

        .twPc-avatarLink {
            background-color: #fff;
            border-radius: 6px;
            display: inline-block !important;
            float: left;
            margin: -30px 5px 0 8px;
            max-width: 100%;
            padding: 1px;
            vertical-align: bottom;
        }

        .twPc-avatarImg {
            border: 2px solid #fff;
            border-radius: 7px;
            box-sizing: border-box;
            color: #fff;
            height: 72px;
            width: 72px;
        }

        .twPc-divUser {
            margin: 5px 0 0;
        }

        .twPc-divName {
            font-size: 18px;
            font-weight: 700;
            line-height: 21px;
        }

        .twPc-divName a {
            color: inherit !important;
        }

        .twPc-divStats {
            margin-left: 11px;
            padding: 10px 0;
        }

        .twPc-Arrange {
            box-sizing: border-box;
            display: table;
            margin: 0;
            min-width: 100%;
            padding: 0;
            table-layout: auto;
        }

        ul.twPc-Arrange {
            list-style: outside none none;
            margin: 0;
            padding: 0;
        }

        .twPc-ArrangeSizeFit {
            display: table-cell;
            padding: 0;
            vertical-align: top;
        }

        .twPc-ArrangeSizeFit a:hover {
            text-decoration: none;
        }

        .twPc-StatValue {
            display: block;
            font-size: 18px;
            font-weight: 500;
            transition: color 0.15s ease-in-out 0s;
        }

        .twPc-StatLabel {
            color: #8899a6;
            font-size: 10px;
            letter-spacing: 0.02em;
            overflow: hidden;
            text-transform: uppercase;
            transition: color 0.15s ease-in-out 0s;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        /*.postImg {*/
        /*min-width: 200px;*/
        /*min-height: 200px;*/
        /*max-width: 200px;*/
        /*max-height: 200px;*/
        /*}*/
    </style>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#imageData").hide();
            $("#videoData").hide();

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
        });
    </script>
@endsection

@section('content')
    <div class="twPc-div">
        <a class="twPc-bg twPc-block"></a>

        <div>
            <div class="twPc-button">
                <!-- Twitter Button | you can get from: https://about.twitter.com/tr/resources/buttons#follow -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal"><i
                            class="fa fa-commenting-o" aria-hidden="true"></i> Postear
                </button>
                <button type="button" class="btn btn-success"><i class="fa fa-forward" aria-hidden="true"></i> Seguir
                </button>
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
                <img alt="$mascota->nombre"
                     src="{{$mascota->imagen}}"
                     class="twPc-avatarImg">
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
            <div class="panel panel-info">
                <div class="panel-body">


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
                                        <img class="img-responsive img-rounded" src="{{$feed->image}}">
                                    </div>
                                @endif
                            @endif
                            <p class="text-muted">
                                {{$feed->content}}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    @foreach($feed->comments as $comment)
                        <div class="row">
                            <div class="panel">
                                <div class="panel-body">
                                    <p class="text-muted">
                                        {{$comment}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr>

                    <div class="row">
                        <input type="hidden" id="postId" value="{{$feed->id}}">
                        <div class="col-md-10">
                            <input class="form-control " id="comment" placeholder="Di lo que piensas..."
                                   type="text">
                        </div>
                        <div class="btn-group col-md-2" role="group">
                            <button type="button" class="btn btn-success" id="btnLike">
                                <img class="/img/icons/{{$feed->icon}}"> <span
                                        class="glyphicon glyphicon-thumbs-up"></span>
                            </button>
                            <button type="button" class="btn btn-danger" id="btnDisLike">
                                <img class="/img/icons/{{$feed->icon}}"><span
                                        class="glyphicon glyphicon-thumbs-down"></span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif
    @include('mascota.post')
@endsection
