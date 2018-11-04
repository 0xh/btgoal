<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="BetterGoals">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="/css/sweetalert.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    
    <link rel="apple-touch-icon" sizes="180x180" href="/img/ios/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/img/ios/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/ios/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/img/ios/manifest.json">
    <link rel="mask-icon" href="/img/ios/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5sK9v5PVMvhXUUFXnXvYwSOoB_CfndYM&libraries=places"></script>
    <!-- Scripts -->
    @yield('scripts', '')

    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(
            Spark::scriptVariables(), []
        )); ?>;
    </script>
</head>
<body class="with-navbar mobile">
    <div id="spark-app" v-cloak>
        <!-- Navigation -->

        @if (Auth::check())
        <div class="mobile-nav">
            <div class="m-logo"><a href="/mobile-home" class="brand"><img src="/img/mono-logo.png"></a></div>
            <div class="m-user"><a href="/mobile-settings"><i class="fa fa-lg fa-user" aria-hidden="true"></i></a></div>
        </div>
        @else
            @include('spark::nav.guest')
        @endif

        <!-- Main Content -->
        <div class="container">
            <!-- Current contacts -->
                @yield('content')
        </div>

        <!-- Application Level Modals -->
        @if (Auth::check())
            @include('spark::modals.notifications')
            @include('spark::modals.support')
            @include('spark::modals.session-expired')
        @endif
    </div>

    <!-- JavaScript -->
    <script src="/js/app.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    <!-- Bottom Scripts -->
    @yield('bottom-scripts', '')
</body>
</html>
