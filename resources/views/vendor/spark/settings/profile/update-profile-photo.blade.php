<spark-update-profile-photo :user="user" inline-template>
    <div>
        <div class="alert alert-danger" v-if="form.errors.has('photo')">
            @{{ form.errors.get('photo') }}
        </div>

        <form  role="form">
            <!-- Photo Preview-->
            <div class="form-group">
                <div >
                    <span role="img" class="profile-photo-preview"
                        :style="previewStyle">
                    </span>
                </div>
            </div>

            <!-- Update Button -->
            <div class="form-group">
                <div >
                    <label type="button" class="btn btn-default btn-upload" :disabled="form.busy">
                        <span>Select new photo</span>

                        <input ref="photo" type="file" class="form-control" name="photo" @change="update">
                    </label>
                </div>
            </div>
        </form>
    </div>
</spark-update-profile-photo>
