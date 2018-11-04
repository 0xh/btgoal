@extends('layouts/mobile')
@section('content')

<div class="add-appointment-click" style="    max-width: 360px;
    margin: auto;">
        <span><a class="btn btn-default plus-button" href="/new/mobile-appointment">
        </a><a href="/new/mobile-appointment"><p style="padding: 10px; color: rgb(31, 132,114);font-size: 18px; margin-top: 15px; margin-bottom: 20px;}">Add Activity</p></a></span>
</div>

<span class="m-back"><a href="/mobile-home"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
<div class="row">
    <div class="m-dash col-md-4 col-md-offset-4">
        <!-- Application Dashboard -->
        @forelse ($appointments as $myDate => $events)
            <div class="row m-row">
                <div class="col-xs-4">
                    <img class="icon-size" src="/img/icon-calendar.svg" alt="Calendar">
                </div>
                <div class="col-xs-8">
                    <div class="m-head">
                        @foreach(explode(',', $myDate) as $head) 
                            <h3>{{$head}}</h3>
                        @endforeach
                    </div>        
                </div>
            </div>
            @foreach ($events as $event)
            <div class="row">
                <div class="col-xs-4">
                 <a href="/mobile-appointment/{{ $event->id }}">
                    <img src="{{ $event->photo }}" alt="Appointment Photo" class="img-responsive">
                </a>
                </div>
                <div class="col-xs-8">
                    <a href="/mobile-appointment/{{ $event->id }}">
                        <p><strong>{{ $event->start_date->format('g:ia') }}</strong></p>
                        <p>{{ $event->title }}</p>
                    </a>
                </div>
            </div>
            @endforeach
            @empty 
                <p class="text-center">No appointments for today.</p>
        @endforelse
        <a class="help-btn btn btn-lg" href="tel:{{$user->emergency_phone}}">Call for help</a>
    </div>
</div>
@endsection