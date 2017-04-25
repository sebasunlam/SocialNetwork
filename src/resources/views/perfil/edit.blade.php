@extends('layouts.app')

@section('content')
    <div class="container" >
        <form class="form-horizontal" role="form" method="POST" action="/profile/update">
            {{method_field('PATCH')}}
            <input id="invisible_id" name="invisible" type="hidden" value="{{$perfil->id}}">
            @include('perfil.createeditpartial')
        </form>
    </div>

@endsection