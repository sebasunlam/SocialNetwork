@extends('layouts.app')

@section('content')

    <form class="form-horizontal" role="form" method="POST" action="{{ route('mascota.update',['id'=>$mascota->id]) }}"
          enctype="multipart/form-data">
        {{method_field('PATCH')}}
        <input id="invisible_id" name="invisible" type="hidden" value="{{$mascota->id}}">
        <input id="adopcion" name="adopcion" type="hidden" value="{{$mascota->adopcion}}">
        <input id="pareja" name="pareja" type="hidden" value="{{$mascota->pareja}}">
        <input id="pareja" name="pareja" type="hidden" value="{{$mascota->perdido}}">
        @include('mascota.createEditFormPartial')
    </form>

@endsection