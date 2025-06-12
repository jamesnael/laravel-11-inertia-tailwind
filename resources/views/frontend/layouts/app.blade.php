<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{!isset($is_404)  ? $meta->description : '404 Not Found'}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/styles.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}?v={{ time() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>{{ !isset($is_404) ? $meta->title ?? 'Home' : '404 Not Found' }}</title>
    <style>

    </style>
    @yield('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="{{ isset($body_class) ? $body_class : '' }}">
    @include('frontend.layouts.header')

    @yield('content')

    @include('frontend.layouts.footer')

    <script>
        const searchPage = "{{ route('frontend.search-result') }}";
    </script>

    <script type="text/javascript" src="{{ asset('frontend/js/script-bundle.min.js') }}?v={{ time() }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/script.js') }}?v={{ time() }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/custom.js') }}?v={{ time() }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/sweetalert2.js') }}?v={{ time() }}"></script>
    @yield('script')
    <script>
        $(".overlay").hide();
        
        $('html').on('click', function() {
            setTimeout(getstatus, 1);
        });

        function getstatus() {
            var navbarstatus = document.getElementById('navbarDropdown').getAttribute('aria-expanded');
            if(navbarstatus == 'true') {
                $(".overlay").show();
            } else {
                $(".overlay").hide();
            }
        }
    </script>
</body>

</html>
