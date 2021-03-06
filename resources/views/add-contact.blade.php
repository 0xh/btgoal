@extends('spark::layouts.app')
@section('content')
<div class="panel panel-content panel-default">
     <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                @if (Route::currentRouteName() == 'contacts.create') Add @endif Person Contact
            </div>
            <div class="col-md-6">
                @if (Route::currentRouteName() != 'contacts.create')
                <form class="form-inline" action="/contacts/{{ $contact->id }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button type='submit' class="btn btn-default" value="Delete">
                    Delete
                    </button>
                </form>
                @endif
            </div>
        </div>
     </div>
        <div class="panel-body">
            <div class="row">
                @if ($contact->id)
                    <form action="{{route('contacts.update', $contact->id)}}"  method="post"role="form" enctype="multipart/form-data" >
                    {{ method_field('PUT') }}
                @else
                    <form action="/contacts" role="form" enctype="multipart/form-data"  method="post">
                @endif
                
                {{ csrf_field() }}
                <div class="col-md-6">
                    <div  class="form-group {{ $errors->has('name') ? 'has-error' :'' }}" >
                        <label class="control-label">Name *</label>
                        <input id="name"  type="text" class="form-control" name="name" value="{{ old('name', $contact->name) }}">
                        <span class="help-block">
                            {{$errors->first('name')}}
                        </span>
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' :'' }}" >
                        <label class="control-label">Phone number *</label>
                        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone', $contact->phone) }}">
                        <span class="help-block">
                            {{$errors->first('phone')}}
                        </span>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' :'' }}" >
                        <label class="control-label">Email address</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $contact->email) }}">
                        <span class="help-block" >
                            {{$errors->first('email')}}
                        </span>
                    </div>
                    <div class="form-group {{ $errors->has('organisation') ? 'has-error' :'' }}" >
                        <label class="control-label">Organisation</label>
                        <input type="organisation" class="form-control" name="organisation" value="{{ old('organisation', $contact->organisation) }}">
                        <span class="help-block" >
                            {{$errors->first('organisation')}}
                        </span>
                    </div>
                    <div class="form-group {{ $errors->has('address') ? 'has-error' :'' }}" >
                        <label class="control-label">Address</label>
                        <input id="address" onFocus="geolocate()" type="text" class="form-control" name="address" value="{{ old('address', $contact->address) }}">
                        <span class="help-block" >
                            {{$errors->first('address')}}
                        </span>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" value="Save contact">  
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div>
                            <span role="img" class="contact-photo-preview" @if( old('photo', $contact->photo)) style="background-image:url({{ old('photo', $contact->photo) }});" @else style="background-image: url(&quot;https://www.gravatar.com/avatar/b8a912ad0f9a535e168b7f82d710fe38.jpg?s=200&amp;d=mm&quot);" @endif></span>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('photo') ? 'has-error' :'' }}">
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
                </div>
            </form>
            </div>
        </div>
</div>
@endsection

@section('bottom-scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5sK9v5PVMvhXUUFXnXvYwSOoB_CfndYM&libraries=places&callback=initAutocomplete"
        async defer></script>
<script type="text/javascript">

    $('input[name="photo"]').on('change',function(){
        photo = $('input[name="photo"]').get(0).files[0];
        var formData = new FormData();
        var imagefile = document.querySelector('#file');
        formData.append("photo", imagefile.files[0]);
        axios.post('/api/contact/photo', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (response) {
            $(".photo-error").hide();
            $(".contact-photo-preview").css("background-image", "url(" + response.data + ")");
            $('.photolink').val(response.data);
        })
        .catch(function (error) {
            $(".photo-error").show();
        });
    });
    var placeSearch, autocomplete;
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('address')));

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        
        // document.getElementById('phone').value = "";
        
        // if (typeof place.formatted_phone_number != 'undefined') document.getElementById('phone').value = place.formatted_phone_number;
        document.getElementById('address').value = place.formatted_address;
        // document.getElementById('name').value = place.name;
    }

    // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              // lat: 30.180635,
              // lng: 71.5242088
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              // radius: 500
              radius: position.coords.accuracy
            });
            
            autocomplete.setBounds(circle.getBounds());
          });
        }
    }

</script>
@endsection
