<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
      .capslockMessage { color: red; }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ asset('dist/img/logo_dalam.png') }}" alt="Logo Rasmi eMasa">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Ralat!</h4>
        {!! session('error') !!}
    </div>
    @endif

    <form method="post" action="{{ route('login') }}" class="detectCapslocks" data-message="Butang caps Lock anda sedang aktif">
      @csrf
      <input type="hidden" name="domain" value="internal">
      <div class="form-group has-feedback detectCapslocks">
        <input type="email" class="form-control" placeholder="Alamat Email" name="email" value="{{ old('email') }}" required autofocus>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Katalaluan" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      {{-- <div class="form-group">
        <select class="form-control" name="domain" required>
            <option value="internal" {{ (old('domain') === 'internal') ? 'selected':'' }} >INTERNAL</option>
            <option value="melaka.gov" {{ (old('domain') === 'melaka.gov') ? 'selected':'' }} >MELAKA.GOV</option>
        </select>
      </div> --}}
      <div class="row">
        <div class="col-xs-8">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script>
    $(function() {
        /**
         * Display a warning on capslock
         */
        $('form').on('keypress', function(e) {
            // Detect current character & shift key
            var character = e.keyCode ? e.keyCode : e.which;
            var sftKey = e.shiftKey ? e.shiftKey : ((character == 16) ? true : false);
            // Is caps lock on?
            isCapsLock = (((character >= 65 && character <= 90) && !sftKey) || ((character >= 97 && character <= 122) && sftKey));
            // Display warning and set css
            if (isCapsLock == true) {
                var parent = $(this);
                $('.capslockMessage').remove();
                parent.append('<div class="alert alert-warning capslockMessage" style="margin:10px 0;"><i class="icon fa fa-warning"></i>AMARAN! ' + parent.data('message') + '</div>');
            } else {
               var parent = $(this);
               console.log('tutup');
               $('div').remove('.capslockMessage');
            }
        });
    });
</script>
</body>
</html>
