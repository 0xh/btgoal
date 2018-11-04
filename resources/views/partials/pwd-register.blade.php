<add-member :user="user" inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">Add Team Member</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                            <p>Add the person you are supporting to your team.</p>
                            <label class="control-label">First & last name of the person you are supporting</label>
                            <input type="text" class="form-control" name="name" v-model="form.name">
                            <span class="help-block" v-show="form.errors.has('name')">
                                @{{ form.errors.get('name') }}
                            </span>
                        </div>
                        <div class="form-group" :class="{'has-error': form.errors.has('email')}">
                            <label class="control-label">Email address</label>
                            <input type="email" class="form-control" name="email" v-model="form.email">
                            <span class="help-block" v-show="form.errors.has('email')">
                                @{{ form.errors.get('email') }}
                            </span>
                            <small class="help-block">This will be their username when logging in</small>
                        </div>
                        <div class="form-group" :class="{'has-error': form.errors.has('phone')}">
                            <label class="control-label">Mobile phone number</label>
                            <div class="phone-control">
                                Australia +61 <input type="tel" class="form-control" name="phone" v-model="form.phone">
                                <a class="btn btn-default send-sms">Send test text message</a>
                             </div>
                            <span class="help-block" v-show="form.errors.has('phone')">
                                @{{ form.errors.get('phone') }}
                            </span>
                            <small class="help-block">This is where text message reminders for appointments will be sent. </small>
                            <small class="help-block message-sent" style="display: none;">
                              Test text message sent!
                            </small>
                        </div>
                        <div class="form-group" :class="{'has-error': form.errors.has('password')}">
                            <label class="control-label">Create a password</label>
                            <input type="password" class="form-control" name="password" v-model="form.password">
                            <span class="help-block" v-show="form.errors.has('password')">
                                @{{ form.errors.get('password') }}
                            </span>
                            <small class="help-block">This will be their password when logging in</small>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="emergency_carer" id="emergency_carer" v-model="form.emergency_carer">
                            <label for="emergency_carer" class="control-label">Carer is the emergency contact</label>
                        </div>
                        <div class="form-group emergency-name" :class="{'has-error': form.errors.has('emergency_name')}">
                            <label class="control-label">Emergency contact name</label>
                            <input type="text" class="form-control" name="emergency_name" v-model="form.emergency_name">
                            <span class="help-block" v-show="form.errors.has('emergency_name')">
                                @{{ form.errors.get('emergency_name') }}
                            </span>
                        </div>
                        <div class="form-group emergency-phone" :class="{'has-error': form.errors.has('emergency_phone')}">
                            <label class="control-label">Emergency contact phone</label>
                            <div class="phone-emergency-control">
                                Australia +61 <input type="tel" class="form-control" name="emergency_phone" v-model="form.emergency_phone">
                             </div>
                            <span class="help-block" v-show="form.errors.has('emergency_phone')">
                                @{{ form.errors.get('emergency_phone') }}
                            </span>
                        </div>
                        <!-- Create Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block"
                            @click.prevent="createMember"
                            :disabled="form.busy">
                            Create team member
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- List Members -->
        <div class="row" v-show="members.length > 0">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Current Members</div>
                    <div class="panel-body">
                        <table class="table table-borderless m-b-none">
                            <tbody>
                                <tr v-for="member in members">
                                    <td>
                                        
                                        <img :src="member.photo_url" class="spark-nav-profile-photo m-r-xs">
                                        
                                    </td>
                                    <!-- Name -->
                                    <td>
                                        <div class="btn-table-align">
                                            @{{ member.name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-table-align">
                                            @{{ member.phone }}
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="btn-table-align">
                                            @{{ member.email }}
                                        </div>
                                    </td>
                                    
                                    <!-- Delete Button -->
                                    <td>
                                        <button class="btn btn-danger" @click="deleteMember(member)">
                                        <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</add-member>