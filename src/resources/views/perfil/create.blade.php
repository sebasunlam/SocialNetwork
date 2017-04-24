@extends('layouts.app')

@section('content')
    <div class="container" role="form" method="POST" action="{{ route('profile/create') }}">
        <form class="form-horizontal col-md-offset-2 col-md-8">
            @include('perfil.createeditpartial')
        </form>
    </div>
@endsection