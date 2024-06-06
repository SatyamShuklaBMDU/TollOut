<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Toll Out</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ======= Head ======= -->
    @include('include.head')
    @yield('style-area')
    <!-- End Head -->
</head>

<body>

    <!-- ======= Header ======= -->
    @include('include.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('include.sidebar')
    <!-- End Sidebar-->

    <!-- ======= Main ======= -->
    <main id="main" class="main">

        @yield('content-area')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('include.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- ======= Foot ======= -->
    @include('include.foot1')
    <!-- End Foot -->
    @yield('script-area')

</body>

</html>
