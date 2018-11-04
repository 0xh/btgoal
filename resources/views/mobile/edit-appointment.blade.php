@extends('layouts/mobile')
@section('scripts')
<link rel="stylesheet" type="text/css" href="/css/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css" href="/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css">
@endsection
@section('content')
<div class="row">
    <div class="m-appoint-add col-md-4 col-md-offset-4">
        <span class="m-back"><a href="/mobile-appointment/{{$apt->id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
              @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
              @endif
            @endforeach
        </div> <!-- end .flash-message -->
        <form role="form" enctype="multipart/form-data" method="post" action="/appointment/update/{{ $apt->id }}">
        {{ csrf_field() }}
        <input type="hidden" name="from_mobile" value="1">
        <input type="hidden" name="apt_id" value="{{ old('apt_id', $apt->id) }}">
        <input type="hidden" name="team_id" value="{{ old('team_id', $apt->team_id) }}">
        <!-- Application Details -->
        <div class="main-group form-group">
          <div class="t-banner" >
            <div class="bg-img" style="background: url({{ $apt->photo }}) center center no-repeat; background-size: cover;"></div>
            <img src="{{ $apt->photo }}" class="img-circle" class="img-responsive">
          </div>
        </div>
        <div class="main-group form-group upload-box center {{ $errors->has('main_photo') ? 'has-error' :'' }}">
          <label type="button" class="btn btn-default btn-upload" >
            <span>Upload an image</span>
            <input ref="main_photo" type="file" class="form-control" name="main_photo" onchange='getFilename(this)' >
            <div id="select-file"></div>
          </label>
          
          <span class="help-block" >
             {{$errors->first('main_photo')}}
          </span>
        </div>
        <div class="main-group row form-group center {{ $errors->has('title') ? 'has-error' :'' }}">
            <div class="col-xs-12">
                <label class="label-title">Title</label>
                <input type="text" name="title" value="{{ old('title', $apt->title) }}">
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('start_date') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <label class="label-image" for="datestart"><img src="/img/icon-calendar.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label>Date it starts</label>
                <input id="datestart" type="text" name="start_date" value="{{ old('start_date', $apt->start_date->format('d-m-Y')) }}">
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('start_time') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <label class="label-image" for="timestart"><img src="/img/icon-time.svg" alt="Apponintment Start Time" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label>Time it starts</label>
                <input id="timestart" type="text" name="start_time" value="{{ old('start_time', $apt->start_date->format('g:ia')) }}">
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('end_time') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <label class="label-image" for="timeend"><img src="/img/icon-time.svg" alt="Apponintment End Time" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label>Time it finishes</label>
                <input id="timeend" type="text" name="end_time" value="{{ old('end_time', $apt->end_date->format('g:ia')) }}">
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('organisation_id') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <img @if($apt->organisation && $apt->organisation->photo) src='{{ $apt->organisation->photo }}' style='margin-top: 5px;' @else src="/img/icon-where.svg" @endif alt="Apponintment Where" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label>Where are you going</label>
                <select id="organisation_id" class="select2 form-control" name="organisation_id" >
                  <option value="0">None</option>
                  @foreach ($organisations as $organisation)
                    <option value="{{$organisation->id}}" @if (old('organisation_id', $apt->organisation_id) == $organisation->id ) selected="selected" @endif >{{$organisation->name}}</option>
                  @endforeach
                </select>
                <span class="help-block">
                    {{$errors->first('organisation_id')}}
                </span>
                <a data-toggle="collapse" data-target="#addorganisation">+Add place or organisation</a>
                <div id="addorganisation" class="addorganisation collapse">
                  <span class="help-block" style="display: none;color: #a94442;">
                    Please fill in the required field.
                  </span>
                  @include('partials.addorganisation')
                </div>
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('contact_id') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <img src="/img/icon-with.svg" alt="Apponintment With" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label>Who is it with</label>
                <select id="contact_id" class="select2 form-control" name="contact_id" >
                  <option value="0">None</option>
                  @foreach ($contacts as $contact)
                    <option value="{{$contact->id}}" @if (old('contact_id', $apt->contact_id) == $contact->id ) selected="selected" @endif >{{$contact->name}}</option>
                  @endforeach
                </select>
                <span class="help-block">
                    {{$errors->first('contact_id')}}
                </span>
                <a data-toggle="collapse" data-target="#addcontact">+Add person</a>
                <div id="addcontact" class="addcontact collapse">
                  <span class="help-block" style="display: none;color: #a94442;">
                    Please fill in the required field.
                  </span>
                  @include('partials.addcontact')
                </div>
            </div>
        </div>
        <div class="main-group row form-group">
                <div class="col-xs-4">
                    <img @if($apt->contact->photo) src='{{ $apt->contact->photo }}' @else src="/img/icon-call.svg" @endif alt="Call Contact" class="img-responsive">
                </div>
                <div class="col-xs-8">
                    <label>Call {{ $apt->contact->name }}<br>{{ $apt->contact->phone }}</label>
                </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('$apt->detail') ? 'has-error' :'' }}">
                <div class="col-xs-4">
                    <img src="/img/icon-details.svg" style="margin-top: 5px;" alt="Detail Icon" class="img-responsive">
                </div>
                <div class="col-xs-8">
                    <label class="control-label">Details</label>
                    <textarea id="detail" class="form-control" rows="5" name="detail">{{ old('detail', $apt->detail) }}</textarea>
                    <span class="help-block">
                        {{$errors->first('detail')}}
                    </span>
                </div>
        </div>
        <hr>
        <div class="row tasks">
          <div class="col-md-12">
            @include('partials.mobile-edit-get-ready')
            @include('partials.mobile-edit-getting-there')
            @include('partials.mobile-edit-after-appointment')
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block save-btn">
        Save appointment
        </button>
        </form>
    </div>
</div>
@endsection

@section('bottom-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/datepair.min.js"></script>
<script type="text/javascript" src="/js/jquery.datepair.min.js"></script>
<script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
    $("#addcontact2 #contact_address").attr("id", "contact_address2");
    $("#addcontact3 #contact_address").attr("id", "contact_address3");
    $("#addcontact4 #contact_address").attr("id", "contact_address4");
    $("#addorganisation2 #organisation_address").attr("id", "organisation_address2");
    $("#addorganisation3 #organisation_address").attr("id", "organisation_address3");
    $("#addorganisation4 #organisation_address").attr("id", "organisation_address4");
    $('input[name="start_date"]').datepicker({
      'format': 'd-m-yyyy',
      'weekStart' : 1,
      'autoclose': true
    });
    $('input[name="start_time"]').timepicker({
      'showDuration': true,
      'scrollDefault': '06:30',
      'timeFormat': 'g:ia'
    });
    $('input[name="end_time"]').timepicker({
      'showDuration': true,
      'scrollDefault': '06:30',
      'timeFormat': 'g:ia'
    });
    $('#date-time-ready .time').timepicker({
    'showDuration': true,
    'scrollDefault': '06:30',
    'timeFormat': 'g:ia'
    });
    $('#date-time-there .time').timepicker({
    'showDuration': true,
    'scrollDefault': '06:30',
    'timeFormat': 'g:ia'
    });
    $('#date-time-after .time').timepicker({
    'showDuration': true,
    'scrollDefault': '06:30',
    'timeFormat': 'g:ia'
    });
    $('#date-time .date').datepicker({
    'format': 'd-m-yyyy',
    'weekStart' : 1,
    'autoclose': true
    });
    $('#re_occurance_end_date').datepicker({
    'format': 'd-m-yyyy',
    'autoclose': true
    });
    function getFilename(e) {
      var file = $(e)[0].files[0]['name'];
      $('#select-file').html(file);
      return false;
    };
    $('.addcontact .save-contact').on('click', function (evt) {
    evt.preventDefault();
    select =  $(this).parent().parent().find('select');
    name = $(this).parent().find("input[name='name']").val();
    phone = $(this).parent().find("input[name='phone']").val();
    email = $(this).parent().find("input[name='email']").val();
    organisation = $(this).parent().find("input[name='organisation']").val();
    address = $(this).parent().find("input[name='address']").val();
    photolink = $(this).parent().find("input[name='photolink']").val();
    axios.post('/api/new/contact', {
      name: name,
      phone: phone,
      email: email,
      address: address,
      organisation: organisation,
      photolink: photolink
    })
    .then(function (response) {
      $(".addcontact .help-block").hide();
      $(".addcontact").removeClass('in');
      $(".addcontact input[name='name']").val("");
      $(".addcontact input[name='phone']").val("");
      $(".addcontact input[name='email']").val("");
      $(".addcontact input[name='organisation']").val("");
      $(".addcontact input[type='address']").val("");
      $('#contact_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $('#getting_there_contact_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $('#get_ready_contact_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $('#after_appointment_contact_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $(select).val(response.data["id"]).trigger('change.select2');
    })
    .catch(function (error) {
      $(".addcontact .help-block").show();
    });
  });

  $('.addorganisation .save-organisation').on('click', function (evt) {
    evt.preventDefault();
    select =  $(this).parent().parent().find('select');
    where =  $(this).parent().parent().parent().parent().find('.form-address-input');
    name = $(this).parent().find("input[name='name']").val();
    phone = $(this).parent().find("input[name='phone']").val();
    email = $(this).parent().find("input[name='email']").val();
    website = $(this).parent().find("input[name='website']").val();
    address = $(this).parent().find("input[name='address']").val();
    photolink = $(this).parent().find("input[name='photolink']").val();
    axios.post('/api/new/organisation', {
      name: name,
      phone: phone,
      email: email,
      address: address,
      website: website,
      photolink: photolink
    })
    .then(function (response) {
      $(".addorganisation .help-block").hide();
      $(".addorganisation").removeClass('in');
      $(".addorganisation input[name='name']").val("");
      $(".addorganisation input[name='phone']").val("");
      $(".addorganisation input[name='email']").val("");
      $(".addorganisation input[name='organisation']").val("");
      $(".addorganisation input[type='address']").val("");
      $('#organisation_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $('#get_ready_organisation_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $('#getting_there_organisation_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $('#after_appointment_organisation_id').append($('<option>', { 
          value: response.data["id"],
          text : response.data["name"] 
      })).select2();
      $(select).val(response.data["id"]).trigger('change.select2');
      $(where).val(address);
    })
    .catch(function (error) {
      $(".addorganisation .help-block").show();
    });
  });

  $('input[name="photo"]').on('change',function(){
      photo = $(this).get(0).files[0];
      id = $(this).parent().parent().parent().attr('id');
      var formData = new FormData();
      var imagefile = document.querySelector('#' + id + ' #file');
      formData.append("photo", imagefile.files[0]);
      axios.post('/api/contact/photo', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
      })
      .then(function (response) {
          $('#' + id + ' .photo-error').hide();
          $('#' + id + ' .contact-photo-preview').css("background-image", "url(" + response.data + ")");
          $('#' + id + ' .photolink').val(response.data);
      })
      .catch(function (error) {
          $('#' + id + ' .photo-error').hide();
      });
  });
 /// Google API
  var placeSearch, autocomplete;
  function initAutocomplete() {
    contact_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address')));
    contact_autocomplete.addListener('place_changed', function(){
    document.getElementById('contact_address').value = contact_autocomplete.getPlace().formatted_address;
    });
    contact2_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address2')));
    contact2_autocomplete.addListener('place_changed', function(){
    document.getElementById('contact_address2').value = contact2_autocomplete.getPlace().formatted_address;
    });
    contact3_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address3')));
    contact3_autocomplete.addListener('place_changed', function(){
    document.getElementById('contact_address3').value = contact3_autocomplete.getPlace().formatted_address;
    });
    contact4_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address4')));
    contact4_autocomplete.addListener('place_changed', function(){
    document.getElementById('contact_address4').value = contact4_autocomplete.getPlace().formatted_address;
    });
    organisation1_autocomplete = new google.maps.places.Autocomplete((document.getElementById('organisation_address')));
    organisation1_autocomplete.addListener('place_changed', function(){
    document.getElementById('organisation_address').value = organisation1_autocomplete.getPlace().formatted_address;
    });
    organisation2_autocomplete = new google.maps.places.Autocomplete((document.getElementById('organisation_address2')));
    organisation2_autocomplete.addListener('place_changed', function(){
    document.getElementById('organisation_address2').value = organisation2_autocomplete.getPlace().formatted_address;
    });
    organisation3_autocomplete = new google.maps.places.Autocomplete((document.getElementById('organisation_address3')));
    organisation3_autocomplete.addListener('place_changed', function(){
    document.getElementById('organisation_address3').value = organisation3_autocomplete.getPlace().formatted_address;
    });
    organisation4_autocomplete = new google.maps.places.Autocomplete((document.getElementById('organisation_address4')));
    organisation4_autocomplete.addListener('place_changed', function(){
    document.getElementById('organisation_address4').value = organisation4_autocomplete.getPlace().formatted_address;
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
  $(".select2").select2();
  // Pre fill addresses upon selection
  $('#organisation_id').on('select2:select', function (evt) {
  axios.get('/api/organisation/' + evt.params.data.id)
  .then(function (response) {
    $('#address').val(response.data.address);
  });
  });

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5sK9v5PVMvhXUUFXnXvYwSOoB_CfndYM&libraries=places&callback=initAutocomplete"
  async defer></script>
@endsection
