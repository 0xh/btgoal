@extends('layouts/mobile')
@section('content')
<div class="row">
    <div class="m-people-modify col-md-4 col-md-offset-4">
        <span class="m-back"><a href="/mobile/places"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
              @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
              @endif
            @endforeach
        </div> <!-- end .flash-message -->
        @if ($organisation->id)
          <form action="{{route('organisations.update', $organisation->id)}}"  method="post"role="form" enctype="multipart/form-data" >
          {{ method_field('PUT') }}
        @else
            <form action="/organisations" role="form" enctype="multipart/form-data"  method="post">
        @endif
        {{ csrf_field() }}
        <input type="hidden" name="from_mobile" value="1">
        <div class="form-group center main-photo">
          <div>
            <span role="img" class="contact-photo-preview" @if( old('photo', $organisation->photo)) style="background-image:url({{ old('photo', $organisation->photo) }});" @else style="background-image: url(&quot;https://www.gravatar.com/avatar/b8a912ad0f9a535e168b7f82d710fe38.jpg?s=200&amp;d=mm&quot);" @endif></span>
          </div>
        </div>
        <div class="row form-group center {{ $errors->has('photo') ? 'has-error' :'' }}">
          <label type="button" class="btn btn-default btn-upload" >
            <span>Select new photo</span>
            <input ref="photo" type="file" id="file" class="form-control" name="photo">
            <div id="select-file"></div>
          </label>
          <input class="photolink" type="hidden" name="photolink" value="">
          <span class="help-block photo-error" style="color: #a94442;display: none;">
            Photo must be less than 5MB.
          </span>
        </div>
        <div  class="row form-group {{ $errors->has('name') ? 'has-error' :'' }}" >
            <div class="col-xs-4">
                <img src="/img/icon-with.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label class="control-label required">Name *</label>
                <input id="name"  type="text" class="form-control" name="name" value="{{ old('name', $organisation->name) }}">
                <span class="help-block">
                    {{$errors->first('name')}}
                </span>
            </div>
        </div>
        <div class="row form-group {{ $errors->has('address') ? 'has-error' :'' }}" >
            <div class="col-xs-4">
                <img src="/img/icon-where.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label class="control-label required">Address *</label>
                <input id="contact_address" onFocus="geolocate()" type="text" class="form-control" name="address" value="{{ old('address', $organisation->address) }}">
                <span class="help-block" >
                    {{$errors->first('address')}}
                </span>
            </div>
        </div>
        <div class="row form-group {{ $errors->has('phone') ? 'has-error' :'' }}" >
            <div class="col-xs-4">
                <img src="/img/icon-call.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label class="control-label">Phone number</label>
                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone', $organisation->phone) }}">
                <span class="help-block">
                    {{$errors->first('phone')}}
                </span>
            </div>
        </div>
        <div class="row form-group {{ $errors->has('email') ? 'has-error' :'' }}" >
            <div class="col-xs-4">
                <img src="/img/icon-mail.svg" alt="Calendar" class="img-responsive top-space">
            </div>
            <div class="col-xs-8">
                <label class="control-label">Email address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $organisation->email)}}">
                <span class="help-block" >
                    {{$errors->first('email')}}
                </span>
            </div>
        </div>
        <div class="row form-group {{ $errors->has('website') ? 'has-error' :'' }}" >
            <div class="col-xs-4">
                <img src="/img/icon-website.svg" alt="Calendar" class="img-responsive top-space">
            </div>
            <div class="col-xs-8">
                <label class="control-label">Website</label>
                <input type="website" class="form-control" name="website" value="{{ old('website', $organisation->website) }}">
                <span class="help-block" >
                    {{$errors->first('website')}}
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block save-btn">
        Save place contact
        </button>
        </form>
    </div>
</div>
@endsection

@section('bottom-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
  $('input[name="photo"]').on('change',function(){
      photo = $(this).get(0).files[0];
      var formData = new FormData();
      var imagefile = document.querySelector('#file');
      formData.append("photo", imagefile.files[0]);
      axios.post('/api/contact/photo', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
      })
      .then(function (response) {
          $('.photo-error').hide();
          $('.contact-photo-preview').css("background-image", "url(" + response.data + ")");
          $('.photolink').val(response.data);
      })
      .catch(function (error) {
          $('.photo-error').hide();
      });
  });
 /// Google API
  var placeSearch, autocomplete;
  function initAutocomplete() {
    contact_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address')));
    contact_autocomplete.addListener('place_changed', function(){
    document.getElementById('contact_address').value = contact_autocomplete.getPlace().formatted_address;
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
