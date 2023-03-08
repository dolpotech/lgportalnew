<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Local Government | Dashboard</title>
    {{--style--}}
    @include('Backend.layouts.include.style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('public/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
    </div>

    {{--  header--}}
    @include('Backend.layouts.include.header')

    <!-- Main Sidebar Container -->
    @include('Backend.layouts.include.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    {{-- footer--}}
    @include('Backend.layouts.include.footer')
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('Backend.layouts.include.script')
    <script src="{{ asset('public/js/app.js') }}"></script>

</body>
</html>
