@extends('layouts/no-left')
<!--
@section('scripts')
    @if (Spark::billsUsingStripe())
        <script src="https://js.stripe.com/v2/"></script>
    @else
        <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    @endif
@endsection
-->

@section('content')
<spark-settings :user="user" :teams="teams" inline-template>
<div class="spark-screen panel-content">
    @include('partials.onboarding')
   <!-- Teams -->
    @if (Spark::usesTeams())
        <div role="tabpanel" class="tab-pane" id="{{str_plural(Spark::teamString())}}">
            @include('spark::settings.teams')
        </div>
    @endif

    @include('partials.pwd-register')
 </div>
</spark-settings>
@endsection

@section('bottom-scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
<script>
$( document ).ready(function() {
  jQuery('input[name="phone"]').mask('000-000-000', {placeholder: "###-###-###"});
});
$( document ).ready(function() {
  jQuery('input[name="emergency_phone"]').mask('000-000-000', {placeholder: "###-###-###"});
});
jQuery(".emergency-name").hide();
jQuery(".emergency-phone").hide();
$('input[name="emergency_carer"]').on('click', function (evt) {
  jQuery(".emergency-name").toggle();
  jQuery(".emergency-phone").toggle();
});

$('.send-sms').on('click', function (evt) {
  evt.preventDefault();
  phone = $(".phone-control input[name='phone']").val();
  axios.post('/api/sms/test', {
    phone: phone
  })
  .then(function (response) {
    $(".message-sent").show();
  })
  .catch(function (error) {
    $(".message-sent").hide();
  });
});
</script>
@endsection
