@extends('layouts.app')

@section('content')
    <div class="container" >
        <form class="form-horizontal col-md-offset-2 col-md-8" role="form" method="POST" action="{{ route('profile.store') }}">
            @include('perfil.createeditpartial')
        </form>
    </div>
@endsection