<!-- getting_there_title -->
<div class="col-md-4">
  <div class="panel panel-content panel-default">
    <div class="panel-heading">
      Getting There
    </div>
    <div class="panel-body">
        <!-- Title -->
        <div class="form-group {{ $errors->has('getting_there_title') ? 'has-error' :'' }}" >
          <label class="control-label">Title</label>
          <input id="getting_there_title" type="text" class="form-control" name="getting_there_title" value="{{ old('getting_there_title') }}">
          <span class="help-block">
              {{$errors->first('getting_there_title')}}
          </span>
        </div>
        <!-- Start Time -->
        <div id="date-time-there">
          <div id="date-time" class="form-group {{ $errors->has('getting_there_start_time') ? 'has-error' :'' }}" >
            <label class="control-label">Start time</label>
            <input id="getting_there_start_time" type="text" class="time start form-control" name="getting_there_start_time" value="{{ old('getting_there_start_time') }}">
            <span class="help-block">
                {{$errors->first('getting_there_start_time')}}
            </span>
          </div>
          
          <!-- End Time -->
          <div id="date-time" class="form-group {{ $errors->has('getting_there_end_time') ? 'has-error' :'' }}" >
            <label class="control-label">End time</label>
            <input id="getting_there_end_time" type="text" class="time end form-control" name="getting_there_end_time" value="{{ old('getting_there_end_time') }}">
            <span class="help-block">
                {{$errors->first('getting_there_end_time')}}
            </span>
          </div>
        </div>
        <!-- SMS Reminder  -->
        <div class="form-group {{ $errors->has('getting_there_send_sms') ? 'has-error' :'' }}" >
          <div class="checkbox">
            <label><input id="getting_there_send_sms" type="checkbox"  name="getting_there_send_sms"  
            @if (old('getting_there_send_sms') == "on")
             checked
            @endif
            >Send a reminder</label>
          </div>
          <span class="help-block">When a reminder is set, a SMS will be sent at the start of the appointment</span>
          <span class="help-block">
              {{$errors->first('getting_there_send_sms')}}
          </span>
        </div>
        <div class="form-group {{ $errors->has('getting_there_detail') ? 'has-error' :'' }}" >
          <label class="control-label">Details</label>
          <textarea id="getting_there_detail" class="form-control" rows="5" name="getting_there_detail">{{ old('getting_there_detail') }}</textarea>
          <span class="help-block">
              {{$errors->first('getting_there_detail')}}
          </span>
        </div>
        <!-- Contact  -->
        <div class="form-group {{ $errors->has('getting_there_contact_id') ? 'has-error' :'' }}" >
          <label class="control-label">Who is this with?</label>
          <select id="getting_there_contact_id" class="select2 form-control" name="getting_there_contact_id">
            <option value="0">None</option>
            @foreach ($contacts as $contact)
              <option value="{{$contact->id}}" @if (old('getting_there_contact_id') == $contact->id ) selected="selected" @endif>{{$contact->name}}</option>
            @endforeach
          </select>
          <span class="help-block">
              {{$errors->first('getting_there_contact_id')}}
          </span>
          <a data-toggle="collapse" data-target="#addcontact3">+Add person</a>
          <div id="addcontact3" class="addcontact collapse">
            <span class="help-block" style="display: none;color: #a94442;">
              Please fill in the required field.
            </span>
            @include('partials.addcontact')
          </div>
        </div>
        <!-- Organisation  -->
        <div class="form-group {{ $errors->has('getting_there_organisation_id') ? 'has-error' :'' }}" >
            <label class="control-label">Place or organisation</label>
            <select id="getting_there_organisation_id" class="select2 form-control" name="getting_there_organisation_id" value="{{ old('getting_there_organisation_id') }}">
              <option value="0">None</option>
              @foreach ($organisations as $organisation)
                <option value="{{$organisation->id}}" @if (old('getting_there_organisation_id') == $organisation->id ) selected="selected" @endif>{{$organisation->name}}</option>
              @endforeach
            </select>
            <span class="help-block">
                {{$errors->first('getting_there_organisation_id')}}
            </span>
            <a data-toggle="collapse" data-target="#addorganisation3">+Add place or organisation</a>
            <div id="addorganisation3" class="addorganisation collapse">
              <span class="help-block" style="display: none;color: #a94442;">
                Please fill in the required field.
              </span>
              @include('partials.addorganisation')
            </div>
        </div>        

         <!-- Address  -->
        <div class="form-group {{ $errors->has('getting_there_address') ? 'has-error' :'' }}" >
              <label class="control-label">Where?</label>
              <input id="getting_there_address" type="text" class="form-control form-address-input" name="getting_there_address" value="{{ old('getting_there_address') }}">
              <span class="help-block">
                  {{$errors->first('getting_there_address')}}
              </span>
        </div>

</div>
</div>
</div>

