@extends('layouts/mobile')
@section('content')
<div class="row">
    <div class="m-people col-md-4 col-md-offset-4">
        <!-- Application Details -->
        <h3 class="text-center"><span class="m-back"><a href="/mobile-home"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>Places</h3>
        
        <div class="row">
        <span><a class="btn btn-default plus-button" href="/mobile/add/place">
        </a><a href="/mobile/add/place"><p style="padding: 10px; color: rgb(31, 132,114);font-size: 18px;">Add Places</p></a></span>
        </div>
        
        @foreach ($places as $place)
            <div class="row">
                <div class="col-xs-3"><img @if($place->photo) src='{{ $place->photo }}' @else src="/img/icon-with.svg" @endif alt="Apponintment Image" class="img-responsive"></div>
                <div class="col-xs-6"><a target="_blank" href="{{$place->map}}" class="name">{{$place->name}}<br>{{$place->address}}</a></div>
                <div class="col-xs-3"><a href="/mobile/place/{{$place->id}}"><img class="edit-photo" src="/img/icon-edit-grey.svg"></a></div>
            </div>
        @endforeach
    </div>
</div>
@endsection
