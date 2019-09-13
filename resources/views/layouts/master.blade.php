<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }} - {{ env('APP_SHORT_NAME') }}</title>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- bootstrap datetimepicker -->
  <link rel="stylesheet" href="{{ asset('bower_components\bootstrap-datetimepicker\bootstrap-datetimepicker.min.css') }}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.css') }}">

  <link rel="stylesheet" href="{{ asset('bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">

  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/pcrs.css') }}" rel="stylesheet">

  <link href="{{ asset('dist/css/easyui.css') }}" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .table-fixed thead {
    width: 98%;
    }
    .table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
    }
    .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
    display: block;
    }
    .table-fixed tbody td, .table-fixed thead > tr> th {
    float: left;
    border-bottom-width: 0;
    }
</style>

</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">

  @include('layouts.header')
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  @include('layouts.navigation')
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Mark js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
<!-- tree view -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<!-- lodash -->
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.4/lodash.min.js"></script>
<!-- sweet alert -->
<script src="https://unpkg.com/sweetalert2@7.1.2/dist/sweetalert2.all.js"></script>
<!-- add clear -->
<script src="{{ asset('bower_components/bootstrap-add-clear/bootstrap-add-clear.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.actual/1.0.19/jquery.actual.min.js"></script>

<script src="{{ asset('dist/js/jquery.easyui.min.js') }}"></script>

<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.1.3/dist/jspdf.plugin.autotable.js"></script>
<script src="{{ asset('dist/js/jspdf.plugin.text-align.js') }}"></script>

<!-- fullCalendar -->
<script src="{{ asset('bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
<!-- bootstrap datetimepicker -->
<script src="{{ asset('bower_components/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<!-- multimodal -->
<script src="{{ asset('bower_components/bootstrap-multimodal/multimodal.min.js') }}"></script>

<!-- bootstrap time picker -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script>
  var base_url = '{{ url('') }}/';
  var bulan = {!! pcrsBulan()->toJson(JSON_NUMERIC_CHECK) !!};

  function login() {
    return {
        401: function() {
            // x login redirect
        	window.location.href = base_url;
        }
    };
  }

  $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.sidebar-menu').tree()

    $('.btn-switch-role').on('click', function(e) {
        e.preventDefault();
        var role = $(this).data('role');

        swal({
            title: 'Amaran!',
            text: 'Anda pasti untuk menukar peranan?',
            type: 'warning',
            cancelButtonText: 'Tidak',
            showCancelButton: true,
            confirmButtonText: 'Ya!',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !swal.isLoading(),
            preConfirm: (email) => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: base_url + "rpc/switch_role/" + role,                
                        success: function() {
                            resolve();
                        },
                        error: function() {
                            reject();
                        },
                        statusCode: login()
                    });
                })
            }
        }).then((result) => {
            if (result.value) {
                document.location = '{{ route('dashboard') }}';
            }
        }).catch(function () {
            swal({
                title: 'Ralat!',
                text: 'Anda tidak dibenarkan untuk melakukan tindakan ini!',
                type: 'error'
            });
        });
    });
  })
</script>

@yield('scripts')

</body>
</html>
