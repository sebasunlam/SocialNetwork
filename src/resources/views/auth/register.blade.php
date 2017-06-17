@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrarse</div>
                <div class="panel-body">
                    @include('auth.registerpartial')
                    <div class="row">
                        <p class="col-md-offset-1 lead">
                            Tambien podes usar tu red social favorita
                        </p>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                @include('shared.socialbuttons')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
