@extends('layouts/mobile')
@section('content')
<mobile-task :task="{{json_encode($task)}}" inline-template>
<div>
<div class="row">
    <div class="m-appoint col-md-4 col-md-offset-4">
        <!-- Application Details -->
        <h3 class="text-center"><span class="m-back"><a href="/mobile-appointment/{{$task->appointment_id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>{{ $task->title }}</h3>
        <div class="row">
            <div class="col-xs-3">
                <img src="/img/icon-calendar.svg" alt="Calendar">
            </div>
            <div class="col-xs-9">
                <p>{{ $task->start_date->format('l') }}<br>{{ $task->start_date->format('d/m/Y') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <img src="/img/icon-time.svg" alt="Time Icon" class="img-responsive">
            </div>
            <div class="col-xs-9">
                <p>From {{ $task->start_date->format('g:ia') }}<br>to {{ $task->end_date->format('g:ia') }}</p>
            </div>
        </div>
        @if ($map != '#')
        <div class="row">
            <div class="col-xs-3">
                <a href="{{ $map }}"><img @if($task->organisation && $task->organisation->photo) src='{{ $task->organisation->photo }}' style='margin-top: 5px;' @else src="/img/icon-where.svg" @endif alt="Apponintment Image" class="img-responsive"></a>
            </div>
            <div class="col-xs-9">
                <p> <a href="{{ $map }}">
                @if ($task->organisation) {{$task->organisation->name}} @endif
                <br>{{ $address }}</a></p>
            </div>
        </div>
        @if ($task->organisation && $task->organisation->phone != '')
        <div class="row">
            <a href="tel:{{ $task->organisation->phone}}">
                <div class="col-xs-3">
                    <img src="/img/icon-call.svg" alt="Apponintment Image" class="img-responsive">
                </div>
                <div class="col-xs-9">
                    <p>Call {{$task->organisation->name}}<br> <span class="phone-number">{{$task->organisation->phone}}</span></p>
                </div>
            </a>
        </div>
        @endif
        @endif
        @if ($task->contact)
        <div class="row">
            <a href="tel:{{ $task->contact->phone}}">
            <div class="col-xs-3">
                <img @if($task->contact->photo) src='{{ $task->contact->photo }}' style='margin-top: 5px;' @else src="/img/icon-with.svg" @endif alt="Apponintment Image" class="img-responsive">
            </div>
            <div class="col-xs-9">
                <p>With {{ $task->contact->name }}<br> <span class="phone-number">{{ $task->contact->phone}}</span></p>
            </div>
            </a>
        </div>
        @endif
        @if($task->detail)
        <div class="row">
            <div class="col-xs-3">
                <img src="/img/icon-details.svg" alt="Detail Icon">
            </div>
            <div class="col-xs-9">
                <p>{{$task->detail}}</p>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class=" m-appoint col-md-4 col-md-offset-4 text-center">
        <label type="button" class="btn btn-default btn-icon btn-upload btn-block" :disabled="form.busy">
            <i class="fa fa-2x fa-thumbs-up" aria-hidden="true"></i><span>Done</span>
            <input class="btn-hide" type="Submit" @click.prevent="checkIn">
        </label>
        
        <div class="alert alert-warning" v-show="checkin=='0'">Already completed</div>
        <div class="alert alert-success" v-show="checkin=='1'">Task completed</div>
        <div class="alert alert-success" v-show="checkin=='2'">Whoops, looks like you've pressed done a bit early!</div>
    </div>
</div>
</div>
</mobile-task>
@endsection