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

    .twPc-avatarImgComments {
        border: 2px solid #fff;
        border-radius: 7px;
        box-sizing: border-box;
        color: #fff;
        height: 35px;
        width: 35px;
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
</style>
<div class="twPc-div">
    <a class="twPc-bg twPc-block"></a>
    <div>
        <div class="twPc-button">
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
                    <a href="#" title="{{$posts}} posts">
                        <span class="twPc-StatLabel twPc-block">Posts</span>
                        <span class="twPc-StatValue">{{$posts}}</span>
                    </a>
                </li>
                <li class="twPc-ArrangeSizeFit">
                    <a href="#" title="{{$followers}} seguidores">
                        <span class="twPc-StatLabel twPc-block">Seguidores</span>
                        <span class="twPc-StatValue">{{$followers}}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(400)->generate('QrCode as PNG image!')) }} ">
</div>

