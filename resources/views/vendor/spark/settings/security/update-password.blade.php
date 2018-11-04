<spark-update-password inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">Change Password</div>

        <div class="panel-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your password has been updated!
            </div>

            <form  role="form">
                <!-- Current Password -->
                <div class="form-group" :class="{'has-error': form.errors.has('current_password')}">
                    <label class=" control-label">Current password</label>

                    <div >
                        <input type="password" class="form-control" name="current_password" v-model="form.current_password">

                        <span class="help-block" v-show="form.errors.has('current_password')">
                            @{{ form.errors.get('current_password') }}
                        </span>
                    </div>
                </div>

                <!-- New Password -->
                <div class="form-group" :class="{'has-error': form.errors.has('password')}">
                    <label class=" control-label">New password</label>

                    <div >
                        <input type="password" class="form-control" name="password" v-model="form.password">

                        <span class="help-block" v-show="form.errors.has('password')">
                            @{{ form.errors.get('password') }}
                        </span>
                    </div>
                </div>

                <!-- New Password Confirmation -->
                <div class="form-group" :class="{'has-error': form.errors.has('password_confirmation')}">
                    <label class=" control-label">Confirm password</label>

                    <div >
                        <input type="password" class="form-control" name="password_confirmation" v-model="form.password_confirmation">

                        <span class="help-block" v-show="form.errors.has('password_confirmation')">
                            @{{ form.errors.get('password_confirmation') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group">
                    <div >
                        <button type="submit" class="btn btn-primary btn-lg btn-block"
                                @click.prevent="update"
                                :disabled="form.busy">

                            Change password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-password>
