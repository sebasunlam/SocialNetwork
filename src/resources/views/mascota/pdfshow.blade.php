
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
</div>
