@extends('layouts/mobile')
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
    <!-- Profile -->
    @include('spark::settings.profile')
   
    <!-- Security -->
    @include('spark::settings.security')
   
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