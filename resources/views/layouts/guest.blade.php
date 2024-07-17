<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>{{ isset($title) ? $title . ' | ' : '' }}  TukuTuku Nepal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- App favicon -->
    <link rel="icon" href="https://tukutukunepal.com/wp-content/uploads/2022/08/cropped-logo-32x32.jpg" sizes="32x32" />
    <link rel="icon" href="https://tukutukunepal.com/wp-content/uploads/2022/08/cropped-logo-192x192.jpg" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://tukutukunepal.com/wp-content/uploads/2022/08/cropped-logo-180x180.jpg" />
    <meta name="msapplication-TileImage" content="https://tukutukunepal.com/wp-content/uploads/2022/08/cropped-logo-270x270.jpg" />

    <!-- Layout config Js -->
    <script src="{{URL::asset('/assets')}}/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{URL::asset('/assets')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{URL::asset('/assets')}}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{URL::asset('/assets')}}/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{URL::asset('/assets')}}/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('/assets')}}/css/custom_style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="auth-page-wrapper pt-5">

    @yield('content')
    @include('layouts.footer')
    </div>

    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{URL::asset('/assets')}}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{URL::asset('/assets')}}/libs/simplebar/simplebar.min.js"></script>
    <script src="{{URL::asset('/assets')}}/libs/node-waves/waves.min.js"></script>
    <script src="{{URL::asset('/assets')}}/libs/feather-icons/feather.min.js"></script>
    <script src="{{URL::asset('/assets')}}/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{URL::asset('/assets')}}/js/plugins.js"></script>

    <!-- particles js -->
    <script src="{{URL::asset('/assets')}}/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="{{URL::asset('/assets')}}/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="{{URL::asset('/assets')}}/js/pages/password-addon.init.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>


        @if(Session::has('message'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
        }
        toastr.success("{{ session('message') }}");
        @endif

        @if(Session::has('error'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
        }
        toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
        }
        toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
        @endif

        @if(Session::has('success'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
        }
        toastr.success("{{ session('success') }}");
        @endif
        </script>
</body>

</html>

