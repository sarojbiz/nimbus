<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{asset('backend/img/logo/logo.png')}}" rel="icon">
  <title>@yield('title', 'Dashboard') - Nimbusbazar Admin Section</title>
  <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('backend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('backend/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{asset('backend/css/ruang-admin.min.css')}}" rel="stylesheet">
  <link href="{{asset('backend/css/backend_styles.css')}}" rel="stylesheet">  
  @yield('stylesheets')
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    @include('admin.includes.menu')
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        @include('admin.includes.header')
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          
          <!--Row-->
          @yield('content') 
          <!--Row-->

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      @include('admin.includes.footer')
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('backend/vendor/select2/dist/js/select2.min.js')}}"></script>
  <script src="{{ asset('backend/vendor/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
  <script src="{{asset('backend/js/ruang-admin.min.js')}}"></script>
  <script src="{{asset('backend/js/admin_script.js')}}"></script> 
  @yield('scripts')
</body>

</html>