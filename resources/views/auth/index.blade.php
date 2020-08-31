<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', '')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">


    <!-- Bootstrap Core Css -->
    <link href="{{ asset('/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    @yield('style')

</head>

<body class="login-page">
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);"><b>{{ env('APP_NAME') }}</b></a>
    </div>
    <div class="card">
        <div class="body">
            @yield('content')
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('/plugins/node-waves/waves.js') }}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('/plugins/jquery-validation/jquery.validate.js') }}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{ asset('/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

<!-- Notifications Plugin Js -->
<script src="{{ asset('/js/pages/ui/notifications.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('/js/admin.js') }}"></script>
<script src="{{ asset('/js/pages/examples/sign-in.js') }}"></script>
<script src="{{ asset('/js/script.js') }}"></script>
<!-- External Js -->
@yield('script')
@yield('modal')

<script>
    $(document).ready(function () {

        @if(session('error'))
            showNotification('bg-black', '{{session('error')}}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
        @endif

        @if(session('notify'))
            showNotification('bg-green', '{{session('notify')}}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
        @endif

    });
</script>

</body>

</html>