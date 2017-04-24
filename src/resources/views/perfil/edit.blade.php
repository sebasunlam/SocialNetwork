@extends('layouts.app')

@section('content')
    <div class="container" >
        <form class="form-horizontal col-md-offset-2 col-md-8" role="form" method="POST" action="/profile/{{$perfil->id}}">
            {{method_field('PATCH')}}
            <input id="invisible_id" name="invisible" type="hidden" value="{{$perfil->id}}">
            @include('perfil.createeditpartial')
        </form>
    </div>

@endsection