@extends('layouts.app')

@section('content')
    <div class="container" >
        <form class="form-horizontal" role="form" method="POST" action="{{ route('profile.store') }}">
            @include('perfil.createeditpartial')
        </form>
    </div>
@endsection