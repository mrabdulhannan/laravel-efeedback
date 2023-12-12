<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- Animated css -->
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <!-- Bootstrap css -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Bootstrap font icons css -->
	<link rel="stylesheet" href="{{asset('assets/fonts/bootstrap/bootstrap-icons.css')}}">
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/modernizr.js')}}"></script>
    <script src="{{asset('assets/js/moment.js')}}"></script>

    <!-- *************
        ************ Vendor Js Files *************
    ************* -->
    {{-- <!-- Overlay Scroll JS -->
    <script src="{{asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('assets/vendor/overlay-scroll/custom-scrollbar.js')}}"></script> --}}

    <!-- Main Js Required -->
    
    {{-- <script>
        document.getElementById('feedbackDropdown').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior (page refresh or navigation)
            event.stopPropagation(); 
        });
    </script> --}}

    @stack('stylesheet-page-level')
</head>
<body>
    <div id="app">
        <div class="page-wrapper">
            @include('layouts.sidebar')
            <div class="main-container">
                @include('layouts.header')
                @yield('content')
            </div>
        </div>
    </div>
    @stack('script-page-level')
</body>
</html>
