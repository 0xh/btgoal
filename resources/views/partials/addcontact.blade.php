              <div class="form-group">
                <div>
                  <span role="img" class="contact-photo-preview" style="background-image: url(&quot;https://www.gravatar.com/avatar/b8a912ad0f9a535e168b7f82d710fe38.jpg?s=200&amp;d=mm&quot);"></span>
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
              <div  class="form-group {{ $errors->has('name') ? 'has-error' :'' }}" >
                  <label class="control-label">Name *</label>
                  <input id="name"  type="text" class="form-control" name="name" value="{{ old('name', $newcontact->name) }}">
                  <span class="help-block">
                      {{$errors->first('name')}}
                  </span>
              </div>
              <div class="form-group {{ $errors->has('phone') ? 'has-error' :'' }}" >
                  <label class="control-label">Phone number *</label>
                  <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone', $newcontact->phone) }}">
                  <span class="help-block">
                      {{$errors->first('phone')}}
                  </span>
              </div>
              <div class="form-group {{ $errors->has('email') ? 'has-error' :'' }}" >
                  <label class="control-label">Email address</label>
                  <input type="email" class="form-control" name="email" value="{{ old('email', $newcontact->email) }}">
                  <span class="help-block" >
                      {{$errors->first('email')}}
                  </span>
              </div>
              <div class="form-group {{ $errors->has('organisation') ? 'has-error' :'' }}" >
                  <label class="control-label">Organisation</label>
                  <input type="organisation" class="form-control" name="organisation" value="{{ old('organisation', $newcontact->organisation) }}">
                  <span class="help-block" >
                      {{$errors->first('organisation')}}
                  </span>
              </div>
              <div class="form-group {{ $errors->has('address') ? 'has-error' :'' }}" >
                  <label class="control-label">Address</label>
                  <input id="contact_address" onFocus="geolocate()" type="text" class="form-control" name="address" value="{{ old('address', $newcontact->address) }}">
                  <span class="help-block" >
                      {{$errors->first('address')}}
                  </span>
              </div>
              <button class="btn btn-primary btn-block save-contact">Save contact</button>