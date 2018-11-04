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
            <div id="locationField" class="form-group {{ $errors->has('name') ? 'has-error' :'' }}" >
                <label class="control-label">Name *</label>
                <input id="name" type="text" onFocus="geolocate()" class="form-control" name="name">
                <span class="help-block">
                    {{$errors->first('name')}}
                </span>
            </div>
            <div class="form-group {{ $errors->has('address') ? 'has-error' :'' }}" >
                <label class="control-label">Address *</label>
                <input id="organisation_address" onFocus="geolocate()" type="text" class="form-control" name="address">
                <span class="help-block" >
                    {{$errors->first('address')}}
                </span>
            </div>
            <div class="form-group {{ $errors->has('phone') ? 'has-error' :'' }}" >
                <label class="control-label">Phone number</label>
                <input id="phone" type="text" class="form-control" name="phone">
                <span class="help-block">
                    {{$errors->first('phone')}}
                </span>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' :'' }}" >
                <label class="control-label">Email address</label>
                <input type="email" class="form-control" name="email">
                <span class="help-block" >
                    {{$errors->first('email')}}
                </span>
            </div>
            <div class="form-group {{ $errors->has('website') ? 'has-error' :'' }}" >
                <label class="control-label">Website</label>
                <input id="website" type="text" class="form-control" name="website">
                <span class="help-block" >
                    {{$errors->first('website')}}
                </span>
            </div>      
            <button class="btn btn-primary btn-block save-organisation">Save contact</button>