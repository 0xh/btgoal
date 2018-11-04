<update-profile-details :user="user" inline-template>
<div>
    <!-- Success Message -->
    <div class="alert alert-success" v-if="form.successful">
        Your contact information has been updated!
    </div>

    <form  role="form">
        <!-- Name -->
        <div class="form-group" :class="{'has-error': form.errors.has('name')}">
            <label class=" control-label">First & last name</label>
            <div >
                <input type="text" class="form-control" name="name" v-model="form.name">

                <span class="help-block" v-show="form.errors.has('name')">
                    @{{ form.errors.get('name') }}
                </span>
            </div>
        </div>

        <!-- E-Mail Address -->
        <div class="form-group" :class="{'has-error': form.errors.has('email')}">
            <label class=" control-label">Email address</label>
            <div >
                <input type="email" class="form-control" name="email" v-model="form.email">

                <span class="help-block" v-show="form.errors.has('email')">
                    @{{ form.errors.get('email') }}
                </span>
            </div>
        </div>

        <!-- Phone -->
        <div class="form-group" :class="{'has-error': form.errors.has('phone')}">
            <label class=" control-label">Mobile phone number</label>
            <div class="phone-control">
                Australia +61 <input type="tel" class="form-control" name="phone" v-model="form.phone">
             </div>
            <span class="help-block" v-show="form.errors.has('phone')">
                @{{ form.errors.get('phone') }}
            </span>
           
        </div>

        <!-- Update Button -->
        <div class="form-group">
            <div >
                <button type="submit" class="btn btn-primary btn-block"
                        @click.prevent="update"
                        :disabled="form.busy">

                    Update profile
                </button>
            </div>
        </div>
    </form>
        
</div>
</update-profile-details>
