<!-- after_appointment_title -->
<div class="col-md-4">
  <div class="panel panel-content panel-default">
    <div class="panel-heading">
      After Appointment
    </div>
    <div class="panel-body">
        <!-- Title -->
        <div class="form-group {{ $errors->has('after_appointment_title') ? 'has-error' :'' }}" >
          <label class="control-label">Title</label>
          <input id="after_appointment_title" type="text" class="form-control" name="after_appointment_title" value="{{ old('after_appointment_title') }}">
          <span class="help-block">
              {{$errors->first('after_appointment_title')}}
          </span>
        </div>
        <!-- Start Time -->
        <div id="date-time-after">
          <div id="date-time" class="form-group {{ $errors->has('after_appointment_start_time') ? 'has-error' :'' }}" >
            <label class="control-label">Start time</label>
            <input id="after_appointment_start_time" type="text" class="time start form-control" name="after_appointment_start_time" value="{{ old('after_appointment_start_time') }}">
            <span class="help-block">
                {{$errors->first('after_appointment_start_time')}}
            </span>
          </div>
          
          <!-- End Time -->
          <div id="date-time" class="form-group {{ $errors->has('after_appointment_end_time') ? 'has-error' :'' }}" >
            <label class="control-label">End time</label>
            <input id="after_appointment_end_time" type="text" class="time end form-control" name="after_appointment_end_time" value="{{ old('after_appointment_end_time') }}">
            <span class="help-block">
                {{$errors->first('after_appointment_end_time')}}
            </span>
          </div>
        </div>
        <!-- SMS Reminder  -->
        <div class="form-group {{ $errors->has('after_appointment_send_sms') ? 'has-error' :'' }}" >
          <div class="checkbox">
            <label><input id="after_appointment_send_sms" type="checkbox"  name="after_appointment_send_sms"  
            @if (old('after_appointment_send_sms') == "on")
             checked
            @endif
            >Send a reminder</label>
          </div>
          <span class="help-block">When a reminder is set, a SMS will be sent at the start of the appointment</span>
          <span class="help-block">
              {{$errors->first('after_appointment_send_sms')}}
          </span>
        </div>
        <div class="form-group {{ $errors->has('after_appointment_detail') ? 'has-error' :'' }}" >
          <label class="control-label">Details</label>
          <textarea id="after_appointment_detail" class="form-control" rows="5" name="after_appointment_detail">{{ old('after_appointment_detail') }}</textarea>
          <span class="help-block">
              {{$errors->first('after_appointment_detail')}}
          </span>
        </div>

        <!-- Contact  -->
        <div class="form-group {{ $errors->has('after_appointment_contact_id') ? 'has-error' :'' }}" >
          <label class="control-label">Who is this with?</label>
          <select id="after_appointment_contact_id" class="select2 form-control" name="after_appointment_contact_id">
            <option value="0">None</option>
            @foreach ($contacts as $contact)
              <option value="{{$contact->id}}" @if (old('after_appointment_contact_id') == $contact->id ) selected="selected" @endif>{{$contact->name}}</option>
            @endforeach
          </select>
          <span class="help-block">
              {{$errors->first('after_appointment_contact_id')}}
          </span>
          <a data-toggle="collapse" data-target="#addcontact4">+Add person</a>
          <div id="addcontact4" class="addcontact collapse">
            <span class="help-block" style="display: none;color: #a94442;">
              Please fill in the required field.
            </span>
            @include('partials.addcontact')
          </div>
        </div>
        <!-- Organisation  -->
        <div class="form-group {{ $errors->has('after_appointment_organisation_id') ? 'has-error' :'' }}" >
            <label class="control-label">Place or organisation</label>
            <select id="after_appointment_organisation_id" class="select2 form-control" name="after_appointment_organisation_id" value="{{ old('after_appointment_organisation_id') }}">
              <option value="0">None</option>
              @foreach ($organisations as $organisation)
                <option value="{{$organisation->id}}" @if (old('after_appointment_organisation_id') == $organisation->id ) selected="selected" @endif>{{$organisation->name}}</option>
              @endforeach
            </select>
            <span class="help-block">
                {{$errors->first('after_appointment_organisation_id')}}
            </span>
            <a data-toggle="collapse" data-target="#addorganisation4">+Add place or organisation</a>
            <div id="addorganisation4" class="addorganisation collapse">
              <span class="help-block" style="display: none;color: #a94442;">
                Please fill in the required field.
              </span>
              @include('partials.addorganisation')
            </div>
        </div>        

         <!-- Address  -->
        <div class="form-group {{ $errors->has('after_appointment_address') ? 'has-error' :'' }}" >
              <label class="control-label">Where?</label>
              <input id="after_appointment_address" onFocus="geolocate()" type="text" class="form-control form-address-input" name="after_appointment_address" value="{{ old('after_appointment_address') }}">
              <span class="help-block">
                  {{$errors->first('after_appointment_address')}}
              </span>
        </div>
</div>
</div>
</div>

