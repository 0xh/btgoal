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
<div class="panel panel-content  panel-default panel-top">
<div class="panel-heading">
   <div class="row">
        <div class="col-md-6">
            Appointment
        </div>
        <div class="col-md-6">
            <a href="/home" class="btn btn-default">Calendar</a>
            <form method="POST" id="form-delete" class="form-inline" action="/appointment/delete">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id" value="{{$apt->id}}">
            </form>
            <button id="delete" class="btn btn-default">Delete</button>
        </div>
    </div>
</div>
</div>
    <form  role="form" enctype="multipart/form-data" method="post" action="/appointment/update/{{ $apt->id }}">
     @include('partials.edit-appoint')
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-content panel-default">
          <div class="panel-heading">
            Get There Tasks
          </div>
          <div class="panel-body">
            <p>Add additional tasks to get to the appointment and back.</p>
            @include('partials.edit-get-ready')
            @include('partials.edit-getting-there')
            @include('partials.edit-after-appointment')
          </div>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block float-left">
    Save appointment
    </button>
  </form>
 
@endsection
@section('bottom-scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/js/jquery.timepicker.min.js"></script>
  <script type="text/javascript" src="/js/datepair.min.js"></script>
  <script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"></script>
  <script>
  $("#addcontact2 #contact_address").attr("id", "contact_address2");
  $("#addcontact3 #contact_address").attr("id", "contact_address3");
  $("#addcontact4 #contact_address").attr("id", "contact_address4");
  $("#addorganisation2 #organisation_address").attr("id", "organisation_address2");
  $("#addorganisation3 #organisation_address").attr("id", "organisation_address3");
  $("#addorganisation4 #organisation_address").attr("id", "organisation_address4");
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
      jQuery(select).val(response.data["id"]).trigger('change.select2');
    })
    .catch(function (error) {
      $(".addcontact .help-block").show();
    });
  });

  $('.addorganisation .save-organisation').on('click', function (evt) {
    evt.preventDefault();
    select =  $(this).parent().parent().find('select');
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
      jQuery(select).val(response.data["id"]).trigger('change.select2');
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
          console.log('#' + id + ' .contact-photo-preview');
      })
      .catch(function (error) {
          $('#' + id + ' .photo-error').hide();
      });
  });
  // initialize input widgets first
  $('#date-time .time').timepicker({
  'showDuration': true,
  'scrollDefault': '06:30',
  'timeFormat': 'g:ia'
  });
  $('#date-time .date').datepicker({
  'format': 'd-m-yyyy',
  'autoclose': true
  });
  $('#re_occurance_end_date').datepicker({
  'format': 'd-m-yyyy',
  'autoclose': true
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
  $('#get_ready_organisation_id').on('select2:select', function (evt) {
  axios.get('/api/organisation/' + evt.params.data.id)
  .then(response => {
  $('#get_ready_address').val(response.data.address);
  });
  });
  $('#getting_there_organisation_id').on('select2:select', function (evt) {
  axios.get('/api/organisation/' + evt.params.data.id)
  .then(response => {
  $('#getting_there_address').val(response.data.address);
  });
  });
  $('#after_appointment_organisation_id').on('select2:select', function (evt) {
  axios.get('/api/organisation/' + evt.params.data.id)
  .then(response => {
  $('#after_appointment_address').val(response.data.address);
  });
  });
  /// Google API
  var placeSearch, autocomplete;
  function initAutocomplete() {
  autocomplete = new google.maps.places.Autocomplete((document.getElementById('address')));
  autocomplete.addListener('place_changed', function(){
  document.getElementById('address').value = autocomplete.getPlace().formatted_address;
  });
  get_ready_autocomplete = new google.maps.places.Autocomplete((document.getElementById('get_ready_address')));
  get_ready_autocomplete.addListener('place_changed', function(){
  document.getElementById('get_ready_address').value = get_ready_autocomplete.getPlace().formatted_address;
  });
  getting_there_autocomplete = new google.maps.places.Autocomplete((document.getElementById('getting_there_address')));
  getting_there_autocomplete.addListener('place_changed', function(){
  document.getElementById('getting_there_address').value = getting_there_autocomplete.getPlace().formatted_address;
  });
  after_appointment_autocomplete = new google.maps.places.Autocomplete((document.getElementById('after_appointment_address')));
  after_appointment_autocomplete.addListener('place_changed', function(){
  document.getElementById('after_appointment_address').value = after_appointment_autocomplete.getPlace().formatted_address;
  });
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

  $('button#delete').on('click', function(){
  swal({   
    title: "Are you sure?",
    text: "You will not be able to recover this appointment",         type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!", 
    closeOnConfirm: false 
  }, 
       function(){   
    $("#form-delete").submit();
  });
})
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5sK9v5PVMvhXUUFXnXvYwSOoB_CfndYM&libraries=places&callback=initAutocomplete"
  async defer></script>
  @endsection
