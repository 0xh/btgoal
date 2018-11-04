 <div class="panel panel-content  panel-default panel-bottom">
<div class="panel-body">
  <div class="row">
    <div class="col-md-6">
      <!-- Title -->
      <div class="form-group {{ $errors->has('title') ? 'has-error' :'' }}" >
          <label class="control-label">Title</label>
          <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
          <span class="help-block">
              {{$errors->first('title')}}
          </span>
      </div>
      <div id="date-time" class="form-group {{ $errors->has('start_date') ? 'has-error' :'' }}" >
          <label  class="control-label">Date & time</label><br>
          <input id="start_date" type="text" class="date start form-inline form-control" name="start_date" value="{{ old('start_date', Request::get('sdate')) }}">
          <input id="start_time" type="text" class="time start form-inline form-control" name="start_time" value="{{ old('start_time', Request::get('stime')) }}">
          to 
          <input id="end_time" type="text" class="time end form-inline form-control" name="end_time" value="{{ old('end_time', Request::get('etime')) }}">
          <input id="end_date" type="text" class="date end form-inline form-control" name="end_date" value="{{ old('end_date', Request::get('edate')) }}">
          <span class="help-block">
              {{$errors->first('start_date')}}
          </span>
      </div>
      <div class="form-group {{ $errors->has('send_sms') ? 'has-error' :'' }}" >
          <div class="checkbox">
            <label><input id="send_sms" type="checkbox"  name="send_sms" 
            @if (old('send_sms') == "on")
             checked
            @endif
            >
            Send a reminder</label>
          </div>
          <span class="help-block">When a reminder is set, a SMS will be sent at the start of the appointment</span>
          <span class="help-block">
              {{$errors->first('send_sms')}}
          </span>
      </div>
     
      <div class="form-group {{ $errors->has('detail') ? 'has-error' :'' }}" >
          <label class="control-label">Details</label>
          <textarea id="detail" class="form-control" rows="5" name="detail">{{ old('detail') }}</textarea>
          <span class="help-block">
              {{$errors->first('detail')}}
          </span>
      </div>
 
      </div> <!-- 6 col end -->
      <div class="col-md-6">
        <div class="form-group {{ $errors->has('main_photo') ? 'has-error' :'' }}">
          <label type="button" class="btn btn-default btn-upload" >
            <span>Upload an image</span>
            <input ref="main_photo" type="file" class="form-control" name="main_photo" onchange='getFilename(this)' >
            <div id="select-file"></div>
          </label>
          
          <span class="help-block" >
             {{$errors->first('main_photo')}}
          </span>
        </div>
   
        <div class="form-group {{ $errors->has('repeat_appointment') ? 'has-error' :'' }}" >
            <label class="control-label">Repeat appointment</label>
            <select class="form-control" name="repeat_appointment" value="{{ old('repeat_appointment') }}">
              <option value="none" @if (old('repeat_appointment') == 'none' ) selected="selected" @endif>None</option>
              <option value="daily" @if (old('repeat_appointment') == 'daily' ) selected="selected" @endif>Daily</option>
              <option value="weekly" @if (old('repeat_appointment') == 'weekly' ) selected="selected" @endif>Weekly</option>
              <option value="monthly" @if (old('repeat_appointment') == 'monthly' ) selected="selected" @endif>Monthly</option>
              <option value="yearly" @if (old('repeat_appointment') == 'yearly' ) selected="selected" @endif>Yearly</option>
            </select>
            <span class="help-block">
                {{$errors->first('repeat_appointment')}}
            </span>
        </div>
    
        <transition name="fade">
          <div class="form-group {{ $errors->has('re_occurance_end_date') ? 'has-error' :'' }}" >
              <label class="control-label">Repeats until</label>
              <input id="re_occurance_end_date" type="text" class="form-control" name="re_occurance_end_date" value="{{ old('re_occurance_end_date') }}">
              <span class="help-block">
                  {{$errors->first('re_occurance_end_date')}}
              </span>
          </div>
        </transition>
        </div> <!-- 6 col end -->
      </div> <!-- end of row -->
      <hr>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group {{ $errors->has('contact_id') ? 'has-error' :'' }}" >
              <label class="control-label">Who is this with?</label>
              <select id="contact_id" class="select2 form-control" name="contact_id" >
                <option value="0">None</option>
                @foreach ($contacts as $contact)
                  <option value="{{$contact->id}}" @if (old('contact_id') == $contact->id ) selected="selected" @endif >{{$contact->name}}</option>
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
        
            <div class="form-group {{ $errors->has('organisation_id') ? 'has-error' :'' }}" >
                <label class="control-label">Place or organisation</label>
                <select id="organisation_id" class="select2 form-control" name="organisation_id" >
                  <option value="0">None</option>
                  @foreach ($organisations as $organisation)
                    <option value="{{$organisation->id}}" @if (old('organisation_id') == $organisation->id ) selected="selected" @endif >{{$organisation->name}}</option>
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

        </div> <!-- end of col 6 -->
        <div class="col-md-6">
          <div class="form-group {{ $errors->has('address') ? 'has-error' :'' }}" >
              <label class="control-label">Where?</label>
              <input id="address" onFocus="geolocate()" type="text" class="form-control form-address-input" name="address" value="{{ old('address') }}">
              <span class="help-block">
                  {{$errors->first('address')}}
              </span>
          </div>
        </div> <!-- end of col 6 -->
      </div> <!-- end of row -->
    </div>
  </div>