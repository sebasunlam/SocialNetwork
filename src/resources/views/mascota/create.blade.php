@extends('layouts.app')

@section('content')

    <form class="form-horizontal" role="form" method="POST" action="{{ route('mascota.store') }}"
          enctype="multipart/form-data">
        @include('mascota.createEditFormPartial')
    </form>

@endsection