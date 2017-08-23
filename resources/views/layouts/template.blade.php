<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS & SKIN -->
    <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-green.min.css") }}" rel="stylesheet" type="text/css" />

    <!-- SWEET ALERT -->
    <link href="{{ asset("/bower_components/sweetalert/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />

    <!-- FONT AWESOME -->
    <link href="{{ asset("/bower_components/font-awesome-4.6.0/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />


    <!-- ICON -->

    <!-- OTHER CSS -->
    @yield('css')

  </head>
  <body class="skin-green">
    <div class="wrapper">

      <!-- Header -->
      @include('layouts.header')

      <!-- Sidebar -->
      @include('layouts.sidebar')

      <div class="content-wrapper">
          @yield('content')
      </div>

      <!-- Footer -->
      @include('layouts.footer')

    </div>

    <!-- JS -->
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/sweetalert/dist/sweetalert.min.js") }}" type="text/javascript"></script>
    @yield('js')

  </body>
</html>
