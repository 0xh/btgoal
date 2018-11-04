@extends('layouts/mobile')

@section('content')

<div class="m-dash col-md-4 col-md-offset-4">
    <!-- Application Dashboard -->
    <h2 class="text-center"><span class="m-back"><a href="/mobile-appointment/{{ $appointment->id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>New Diary Entry</h2>
    <h3 >{{ $appointment->title }}</h3>
    <div class="row">
    	<div class="col-xs-4">
    		<img src="/img/calendar.svg" alt="Calendar">
    	</div>
    	<div class="col-xs-8">
    		<p>on {{ $appointment->start_date->format('l, d M') }}</p>
    	</div>
    </div>
    <div class="row">
        <div class="col-xs-4">
            <img src="{{ $appointment->photo }}" alt="Apponintment Image" class="img-circle img-responsive">
        </div>
        <div class="col-xs-8">
            <p>Event start from {{ $appointment->start_date->format('h:m A') }} to {{ $appointment->end_date->format('h:m A') }}</p>
        </div>
    </div>
    <dairy :user="user" :appointment="{{$appointment}}" inline-template>
    <form  role="form" @submit.prevent="">
        <div class="row">
            <div class="col-xs-4">
                <img src="/img/icon-note.png" alt="Write note image" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <p>Write note</p>
            </div>
            <div class="col-xs-12" v-show="write_note">
                <div class="form-group" :class="{'has-error': form.errors.has('description')}">
                    <label >Description</label>
                    <textarea class="form-control" rows="4" name="description" v-model="form.description"></textarea>
                    <span class="help-block" v-show="form.errors.has('description')">
                        @{{ form.errors.get('description') }}
                    </span>
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-xs-4">
                <img src="/img/icon-photo.png" alt="Apponintment Image" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <p>Add photo</p>
            </div>
        </div>
    </form>
    </dairy>
</div>

@endsection
