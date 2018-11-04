@extends('spark::layouts.app')
@section('scripts')
    <link rel="stylesheet" type="text/css" href="/css/jquery.timepicker.css" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css">
@endsection
@section('content')    
<div class="flash-message">
  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(Session::has('alert-' . $msg))
  <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
  @endif
  @endforeach
</div> <!-- end .flash-message -->
<form  role="form" method="post" action="/task/update/{{ $task->id }}">
    <div class="panel panel-content panel-default">
        <div class="panel-heading">Task</div>
        <div class="panel-body">
            
            {{ csrf_field() }}
            <input type="hidden" name="start_date" value="{{ $task->start_date->format('d-m-Y') }}">
            <input type="hidden" name="end_date" value="{{ $task->end_date->format('d-m-Y') }}">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' :'' }}" >
                        <label class="control-label">Title</label>
                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $task->title) }}">
                        <span class="help-block">
                            {{$errors->first('title')}}
                        </span>
                    </div>
                    
                    <!-- Start Time -->
                    <div id="date-time" class="form-group {{ $errors->has('start_time') ? 'has-error' :'' }}" >
                        <label class="control-label">Start time</label>
                        <input id="starttime" type="text" class="time start form-control" name="start_time"
                        @if ($task->start_date)
                        value="{{ old('start_time', $task->start_date->format('g:ia')) }}"
                        @else
                        value="{{ old('start_time') }}"
                        @endif
                        >
                        <span class="help-block">
                            {{$errors->first('start_time')}}
                        </span>
                    </div>
                    
                    <!-- End Time -->
                    <div id="date-time" class="form-group {{ $errors->has('end_time') ? 'has-error' :'' }}" >
                        <label class="control-label">End time</label>
                        <input id="endtime" type="text" class="time end form-control" name="end_time"
                        @if ($task->end_date)
                        value="{{ old('end_time', $task->end_date->format('g:ia')) }}"
                        @else
                        value="{{ old('end_time') }}"
                        @endif
                        >
                        <span class="help-block">
                            {{$errors->first('end_time')}}
                        </span>
                    </div>
                    
                    <!-- SMS Reminder  -->
                    <div class="form-group {{ $errors->has('send_sms') ? 'has-error' :'' }}" >
                        <div class="checkbox">
                            <label><input id="send_sms" type="checkbox"  name="send_sms"
                                @if (old('send_sms', $task->send_sms) == 1)
                                checked
                                @endif
                            >Send a reminder</label>
                        </div>
                        <span class="help-block">When a reminder is set, a SMS will be sent at the start of the appointment</span>
                        <span class="help-block">
                            {{$errors->first('send_sms')}}
                        </span>
                    </div>
                    <!-- Detail text area -->
                    <div class="form-group {{ $errors->has('detail') ? 'has-error' :'' }}" >
                        <label class="control-label">Details</label>
                        <textarea id="detail" class="form-control" rows="5" name="detail" >{{ old('detail', $task->detail) }}</textarea>
                        <span class="help-block">
                            {{$errors->first('detail')}}
                        </span>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <!-- Contact  -->
                    <div class="form-group {{ $errors->has('contact_id') ? 'has-error' :'' }}" >
                        <label class="control-label">Who is this with?</label>
                        <select id="contact_id" class="select2 form-control" name="contact_id">
                            <option value="0">None</option>
                            @foreach ($contacts as $contact)
                            <option value="{{$contact->id}}" @if (old('contact_id', $task->contact_id) == $contact->id ) selected="selected" @endif>{{$contact->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">
                            {{$errors->first('contact_id')}}
                        </span>
                    </div>
                    <!-- Organisation  -->
                    <div class="form-group {{ $errors->has('organisation_id') ? 'has-error' :'' }}" >
                        <label class="control-label">Place or organisation</label>
                        <select id="organisation_id" class="select2 form-control" name="organisation_id" value="{{ old('organisation_id') }}">
                            <option value="0">None</option>
                            @foreach ($organisations as $organisation)
                            <option value="{{$organisation->id}}" @if (old('organisation_id', $task->organisation_id) == $organisation->id ) selected="selected" @endif>{{$organisation->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">
                            {{$errors->first('organisation_id')}}
                        </span>
                    </div>
                    <!-- Address  -->
                    <div class="form-group {{ $errors->has('address') ? 'has-error' :'' }}" >
                        <label class="control-label">Where?</label>
                        <input id="address" onFocus="geolocate()" type="text" class="form-control" name="address" value="{{ old('address', $task->address) }}">
                        <span class="help-block">
                            {{$errors->first('address')}}
                        </span>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block float-left">
    Update task
    </button>
</form>
<form method="POST" action="/task/delete">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="id" value="{{$task->id}}">
    <input type="submit" class="btn btn-default btn-block float-left" value="Delete">
</form>
@endsection
@section('bottom-scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/js/jquery.timepicker.min.js"></script>
  <script type="text/javascript" src="/js/datepair.min.js"></script>
  <script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"></script>
  <script>
  // initialize input widgets first
  $('#date-time .time').timepicker({
  'showDuration': true,
  'timeFormat': 'g:ia'
  });
  
  var basicExampleEl = document.getElementById('date-time');
  var datepair = new Datepair(basicExampleEl);
  function getFilename(e) {
  var file = $(e)[0].files[0]['name'];
  $('#select-file').html(file);
  return false;
  }
  $(".select2").select2();
  // Pre fill addresses upon selection
  $('#organisation_id').on('select2:select', function (evt) {
  axios.get('/api/organisation/' + evt.params.data.id)
  .then(response => {
  $('#address').val(response.data.address);
  });
  });

  /// Google API
  var placeSearch, autocomplete;
  function initAutocomplete() {
      autocomplete = new google.maps.places.Autocomplete((document.getElementById('address')));
      autocomplete.addListener('place_changed', function(){
      document.getElementById('address').value = autocomplete.getPlace().formatted_address;
  });
  }
  function geolocate() {
  if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
  var geolocation = {
  lat: position.coords.latitude,
  lng: position.coords.longitude
  };
  var circle = new google.maps.Circle({
  center: geolocation,
  radius: position.coords.accuracy
  });
  autocomplete.setBounds(circle.getBounds());
  });
  }
  }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5sK9v5PVMvhXUUFXnXvYwSOoB_CfndYM&libraries=places&callback=initAutocomplete"
  async defer></script>
  @endsection
