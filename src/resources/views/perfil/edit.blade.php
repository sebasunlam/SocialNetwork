@extends('layouts.app')

@section('content')

        <form class="form-horizontal" role="form" method="POST" action="{{route("profile.update")}}" enctype="multipart/form-data">
            {{method_field('PATCH')}}
            <input id="invisible_id" name="invisible" type="hidden" value="{{$perfil->id}}">
            @include('perfil.createeditpartial')
        </form>


@endsection