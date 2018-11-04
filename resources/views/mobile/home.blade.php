@extends('layouts/mobile')
@section('content')

<div id="spark-app-main" v-cloak>
<div class="m-user-main"><a href="/mobile-settings"><i class="fa fa-3x fa-user" aria-hidden="true"></i></a></div>
</div>
<h2 style="text-align: center;margin-bottom: 30px;">
    {{Auth::user()->name}}
</h2>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right:7px;">
            <div class="background-about-me">
    	        <a class="lg-icon-btn-1 calendar btn btn-lg" href="/mobile/about-me"><p style="padding-top: 70px; ">About Me</p></a>
           </div> 
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-left:7px;">
            <div class="background-1">
    	        <a class="lg-icon-btn-1 calendar btn btn-lg" href="/mobile-calendar"><p style="padding-top: 70px; ">Activity</p></a>
           </div> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right: 7px;">
            <div class="background-2">
                <a class="lg-icon-btn-2 people btn btn-lg" href="/mobile/people"><p style="padding-top: 70px; ">People</p></a>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-left: 7px;">
            <div class="background-3">
                <a class="lg-icon-btn-3 places btn btn-lg" href="/mobile/places"><p style="padding-top: 70px; ">Places</p></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <a class="help-btn btn btn-lg" href="tel:{{$user->emergency_phone}}">Call for help</a>
</div>
@endsection

@section('bottom-scripts')
<script type="text/javascript">
	$(window).on("orientationchange",function(){
	  if(window.orientation == 0) // Portrait
	  {
	    $(".fixed-bottom").css({"position":"fixed"});
	  }
	  else // Landscape
	  {
	    $(".fixed-bottom").css({"position":"initial"});
	  }
	});
</script>
@endsection