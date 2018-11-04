<spark-profile :user="user" inline-template>
    <div>
    <div class="panel panel-default">
        <div class="panel-heading">Profile Settings</div>
	    	<div class="panel-body">
		        <!-- Update Profile Photo -->
		        <div class="row">
		        	<div class="col-md-3" v-if="user">
			        	@include('spark::settings.profile.update-profile-photo')
			        </div>
			        <!-- Update Contact Information -->
			        <div class="col-md-9">
			        	
			        	<!-- Update Profile Details -->
					    @include('settings.profile.update-profile-details')
			        </div>
		        </div>  
	        </div>
	    </div>
    </div>
</spark-profile>
