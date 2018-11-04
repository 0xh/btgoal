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
        <div class="col-xs-10 col-xs-offset-1 text-center">      
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-group" :class="{'has-error': form.errors.has('description')}">
                    <label >Description</label>
                    <input type="text" class="form-control" name="description" v-model="form.description">
                    <span class="help-block" v-show="form.errors.has('description')">
                        @{{ form.errors.get('description') }}
                    </span>
                </div>
                <input class="btn btn-default btn-block" type="Submit" value="Save Note">           
            </form>      

        </div>
    </div>
</div>

@endsection
