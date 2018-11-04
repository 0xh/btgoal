<div class="after-appointment">
    <a class="panel-collapse" data-toggle="collapse" data-target="#after-appointment">After Appointment</a>
    <div id="after-appointment" class="collapse">
          <!-- Title -->
          <div class="main-group form-group {{ $errors->has('after_appointment_title') ? 'has-error' :'' }}" >
            <label class="control-label">Title</label>
            <input id="after_appointment_title" type="text" class="form-control" name="after_appointment_title" value="{{ old('after_appointment_title') }}">
            <span class="help-block">
                {{$errors->first('after_appointment_title')}}
            </span>
          </div>
          <!-- Start Time -->
          <div id="date-time-after">
            <div id="date-time" class="main-group form-group {{ $errors->has('after_appointment_start_time') ? 'has-error' :'' }}" >
              <div class="row">
                <div class="col-xs-4">
                    <label class="label-image" for="after_appointment_start_time"><img src="/img/icon-time.svg" alt="Apponintment Image" class="img-responsive"></label>
                </div>
                <div class="col-xs-8">
                    <label class="control-label">Time it starts</label>
                    <input id="after_appointment_start_time" type="text" class="time start form-control" name="after_appointment_start_time" value="{{ old('after_appointment_start_time') }}">
                    <span class="help-block">
                        {{$errors->first('after_appointment_start_time')}}
                    </span>
                </div>
              </div>
            </div>
            
            <!-- End Time -->
            <div id="date-time" class="main-group form-group {{ $errors->has('after_appointment_end_time') ? 'has-error' :'' }}" >
              <div class="row">
                <div class="col-xs-4">
                    <label class="label-image" for="after_appointment_end_time"><img src="/img/icon-time.svg" alt="Apponintment Image" class="img-responsive"></label>
                </div>
                <div class="col-xs-8">
                    <label class="control-label">Time it finishes</label>
                    <input id="after_appointment_end_time" type="text" class="time end form-control" name="after_appointment_end_time" value="{{ old('after_appointment_end_time') }}">
                    <span class="help-block">
                        {{$errors->first('after_appointment_end_time')}}
                    </span>
                </div>
              </div>
            </div>
          </div>

          <!-- SMS Reminder  -->
          <div class="main-group form-group {{ $errors->has('after_appointment_send_sms') ? 'has-error' :'' }}" >
            <div class="row">
                <div class="col-xs-4">
                    <img src="/img/icon-time.svg" alt="Apponintment Image" class="img-responsive">
                </div>
                <div class="col-xs-8 send-reminder">
                    <div class="checkbox">
                      <label><input id="after_appointment_send_sms" type="checkbox"  name="after_appointment_send_sms"  
                      @if (old('after_appointment_send_sms') == "on")
                       checked
                      @endif
                      >Send a reminder</label>
                    </div>
                    <span class="help-block">
                        {{$errors->first('after_appointment_send_sms')}}
                    </span>
                </div>
              </div>
          </div>

          <!-- Contact  -->
          <div class="main-group form-group {{ $errors->has('after_appointment_contact_id') ? 'has-error' :'' }}" >
            <div class="row">
              <div class="col-xs-4">
                  <img src="/img/icon-with.svg" alt="Apponintment Image" class="img-responsive">
              </div>
              <div class="col-xs-8">
                <label class="control-label">Who is it with</label>
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
            </div>
          </div>
          <!-- Organisation  -->
          <div class="main-group form-group {{ $errors->has('after_appointment_organisation_id') ? 'has-error' :'' }}" >
              <div class="row">
                <div class="col-xs-4">
                    <img src="/img/icon-where.svg" alt="Apponintment Image" class="img-responsive">
                </div>
                <div class="col-xs-8">
                  <label class="control-label">Where are you going</label>
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
              </div>
          </div>        
    </div>
</div>