@extends('layouts.app')

@section('content')
    <div class="container" >
        <form class="form-horizontal" role="form" method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
            @include('perfil.createeditpartial')
        </form>
    </div>
@endsection