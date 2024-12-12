<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Rydechair</title>

  <link href="{{ asset('vendor/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('vendor/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/vendor/dropzone.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/css/date_picker.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/css/custom.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('vendor/js/editor/summernote-bs4.css') }}">
   @stack('head')
</head>

<body class="fixed-nav sticky-footer" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
    <a class="navbar-brand" href="{{ route('vendor.dashboard') }}"><img src="{{ asset('logox.png') }}" alt="" width="165" height="36"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="{{ route('vendor.dashboard') }}">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        @if(Auth::user()->role === 'admin')
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pages">
          <a class="nav-link" href="{{ route('admin.page') }}">
            <i class="fa fa-fw fa-cog"></i>
            <span class="nav-link-text">Pages</span>
          </a>
        </li>        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Settings">
          <a class="nav-link" href="{{ route('admin.settings') }}">
            <i class="fa fa-fw fa-cog"></i>
            <span class="nav-link-text">Settings</span>
          </a>
        </li> 
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Homepage">
          <a class="nav-link" href="{{ route('admin.homepage') }}">
            <i class="fa fa-fw fa-cog"></i>
            <span class="nav-link-text">Home Page</span>
          </a>
        </li>         
        @endif       
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="fa fa-fw fa-sign-out"></i> Logout
          </a>
        </li>
      </ul>      
    </div>
  </nav>
  <!-- /Navigation-->
  <div class="content-wrapper">
    <div class="container-fluid">
        <div class="box_general padding_bottom">
            @if(isset($slot))

            {{ $slot }}
    
            @else
                @section('content')
            @endif
        </div>
    </div>
  </div>
<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-primary">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <script src="{{ asset('vendor/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('vendor/vendor/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('vendor/vendor/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('vendor/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('vendor/vendor/jquery.selectbox-0.2.js') }}"></script>
  <script src="{{ asset('vendor/vendor/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('vendor/js/admin.js') }}"></script>
  <script src="{{ asset('vendor/vendor/dropzone.min.js') }}"></script>
  <script src="{{ asset('vendor/vendor/bootstrap-datepicker.js') }}"></script>
  <script>
  $('input.date-pick').datepicker();
  </script>
  <!-- WYSIWYG Editor -->
  <script src="{{ asset('admin/js/editor/summernote-bs4.min.js') }}"></script>
  <script>
  $('.editor').summernote({
      fontSizes: ['10', '14'],
      toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough']],
          ['fontsize', ['fontsize']],
          ['para', ['ul', 'ol', 'paragraph']]
      ],
      placeholder: 'Write here ....',
      tabsize: 2,
      height: 200
  });
  </script>  
  @stack('scripts')
</body>
</html>