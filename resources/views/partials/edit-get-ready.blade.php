<!-- get_ready_title -->
<div class="col-md-4">
  <div class="panel panel-content panel-default">
    <div class="panel-heading">
      Get Ready
    </div>
    <div class="panel-body">
      <!-- Title -->
      <input type="hidden" name="get_ready_id" value="{{ old('get_ready_id', $get_task->id) }}">
      <div class="form-group {{ $errors->has('get_ready_title') ? 'has-error' :'' }}" >
        <label class="control-label">Title</label>
        <input id="get_ready_title" type="text" class="form-control" name="get_ready_title" value="{{ old('get_ready_title', $get_task->title) }}">
        <span class="help-block">
          {{$errors->first('get_ready_title')}}
        </span>
      </div>
      <!-- Start Time -->
      <div id="date-time-ready">
        <div id="date-time" class="form-group {{ $errors->has('get_ready_start_time') ? 'has-error' :'' }}" >
          <label class="control-label">Start time</label>
          <input id="get_ready_start_time" type="text" class="time start form-control" name="get_ready_start_time" 
          @if ($get_task->start_date)
            value="{{ old('get_ready_start_time', $get_task->start_date->format('g:ia')) }}"
          @else 
            value="{{ old('get_ready_start_time') }}"
          @endif
          >
          <span class="help-block">
            {{$errors->first('get_ready_start_time')}}
          </span>
        </div>
        
        <!-- End Time -->
        <div id="date-time" class="form-group {{ $errors->has('get_ready_end_time') ? 'has-error' :'' }}" >
          <label class="control-label">End time</label>
          <input id="get_ready_end_time" type="text" class="time end form-control" name="get_ready_end_time" 
          @if ($get_task->end_date)
            value="{{ old('get_ready_end_time', $get_task->end_date->format('g:ia')) }}"
          @else 
            value="{{ old('get_ready_end_time') }}"
          @endif
          >
          <span class="help-block">
            {{$errors->first('get_ready_end_time')}}
          </span>
        </div>
      </div>
      
      <!-- SMS Reminder  -->
      <div class="form-group {{ $errors->has('get_ready_send_sms') ? 'has-error' :'' }}" >
        <div class="checkbox">
          <label><input id="get_ready_send_sms" type="checkbox"  name="get_ready_send_sms"  
          @if (old('get_ready_send_sms', $get_task->send_sms) == 1)
             checked
          @endif
          >Send a reminder</label>
        </div>
        <span class="help-block">When a reminder is set, a SMS will be sent at the start of the appointment</span>
        <span class="help-block">
          {{$errors->first('get_ready_send_sms')}}
        </span>
      </div>
      
      <!-- Detail text area -->
      <div class="form-group {{ $errors->has('get_ready_detail') ? 'has-error' :'' }}" >
          <label class="control-label">Details</label>
          <textarea id="get_ready_detail" class="form-control" rows="5" name="get_ready_detail" >{{ old('get_ready_detail', $get_task->detail) }}</textarea>
          <span class="help-block">
              {{$errors->first('get_ready_detail')}}
          </span>
      </div>
      <!-- Contact  -->
      <div class="form-group {{ $errors->has('get_ready_contact_id') ? 'has-error' :'' }}" >
        <label class="control-label">Who is this with?</label>
        <select id="get_ready_contact_id" class="select2 form-control" name="get_ready_contact_id">
          <option value="0">None</option>
          @foreach ($contacts as $contact)
          <option value="{{$contact->id}}" @if (old('get_ready_contact_id', $get_task->contact_id) == $contact->id ) selected="selected" @endif>{{$contact->name}}</option>
          @endforeach
        </select>
        <span class="help-block">
          {{$errors->first('get_ready_contact_id')}}
        </span>
        <a data-toggle="collapse" data-target="#addcontact2">+Add person</a>
        <div id="addcontact2" class="addcontact collapse">
          <span class="help-block" style="display: none;color: #a94442;">
            Please fill in the required field.
          </span>
          @include('partials.addcontact')
        </div>
      </div>
      <!-- Organisation  -->
      <div class="form-group {{ $errors->has('get_ready_organisation_id') ? 'has-error' :'' }}" >
        <label class="control-label">Place or organisation</label>
        <select id="get_ready_organisation_id" class="select2 form-control" name="get_ready_organisation_id" value="{{ old('get_ready_organisation_id') }}">
          <option value="0">None</option>
          @foreach ($organisations as $organisation)
          <option value="{{$organisation->id}}" @if (old('get_ready_organisation_id', $get_task->organisation_id) == $organisation->id ) selected="selected" @endif>{{$organisation->name}}</option>
          @endforeach
        </select>
        <span class="help-block">
          {{$errors->first('get_ready_organisation_id')}}
        </span>
        <a data-toggle="collapse" data-target="#addorganisation2">+Add place or organisation</a>
            <div id="addorganisation2" class="addorganisation collapse">
              <span class="help-block" style="display: none;color: #a94442;">
                Please fill in the required field.
              </span>
              @include('partials.addorganisation')
            </div>
      </div>
      <!-- Address  -->
      <div class="form-group {{ $errors->has('get_ready_address') ? 'has-error' :'' }}" >
        <label class="control-label">Where?</label>
        <input id="get_ready_address" type="text" class="form-control form-address-input" name="get_ready_address" value="{{ old('get_ready_address', $get_task->address) }}">
        <span class="help-block">
          {{$errors->first('get_ready_address')}}
        </span>
      </div>
    </div>
  </div>
</div>