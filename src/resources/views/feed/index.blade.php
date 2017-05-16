@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include("feed.sidebar")
        </div>
        <div class="col-md-8">
            @include("feed.content")
        </div>
        {{--<div class="col-md-2">--}}
            {{--@include("lefbar")--}}
        {{--</div>--}}
    </div>
@endsection