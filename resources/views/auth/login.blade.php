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
    <img src="{{ asset('dist/img/logo_dalam.png') }}" alt="Logo Rasmi PCRS">
                        <span style="font-size:14px; color:rgba(0,0,0,1); vertical-align:bottom; font-weight:bold;">VERSI 2.0</span>
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
      <div class="form-group has-feedback detectCapslocks">
        <input type="text" class="form-control" placeholder="ID Pengguna" name="username" value="{{ old('username') }}" required autofocus>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Katalaluan" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group">
        <select class="form-control" name="domain" required>
            <option value="ldap" {{ (old('domain') === 'melaka.gov') ? 'selected':'' }} >MELAKA.GOV</option>
            <option value="internal" {{ (old('domain') === 'internal') ? 'selected':'' }} >INTERNAL</option>
        </select>
      </div>
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
  
  <br>

<div class="row">

<div class="col-md-12">
<div style="text-align:justify;">
*Sekiranya anda tidak dapat log-masuk ke dalam Sistem PCRS Versi 2.0, sila berhubung dengan Pentadbir PCRS Jabatan/ Bahagian masing-masing untuk proses pendaftaran akaun PCRS 2.0.
</div>

<br>
<div>
Pautan ke PCRS Versi 1.0: <a href="https://pcrsold.melaka.gov.my" target="_blank">https://pcrsold.melaka.gov.my</a>
</div>
</div>

</div>
</div>
<!-- /.login-box -->



        <div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="padding:30px !important;">
                <div class="modal-body">
                    <div class="text-center mb-3" style="margin-top:10px; margin-bottom:20px;">
                        <img src="{{ asset('images/jata_melaka_100.png') }}" style="width:auto; height: 80px; margin-bottom: 10px">
                        
                        &nbsp;
                        
                        <img src="{{ asset('images/logo_pcrs.png') }}" style="width:auto; height: 70px; margin-bottom: 10px">
                        
                    </div>
                    
                    

                    <div align="center" style="margin-bottom:40px; font-size:20px; font-weight:bold;">
                        PUNCTUALITY CASCADING REPORTING SYSTEM (PCRS) VERSI 2.0
                    </div>
                    
                    <div align="justify">
                    
                    	<ol style="padding-left:15px !important;">
                        
                        <li style="margin-bottom:10px;">Bermula  Jun 2022, PCRS Versi 2.0 akan digunakan bagi menggantikan PCRS Versi 1.0.</li>
                        <li style="margin-bottom:10px;">Sekiranya anda <b>tidak berjaya log-masuk</b> ke dalam Sistem PCRS 2.0, sila berhubung dengan <b>Pentadbir PCRS Jabatan/ Bahagian masing-masing</b> .</li>
                        <li style="margin-bottom:10px;">Anda juga boleh merujuk kepada Manual Pengguna yang disediakan atau mengajukan pertanyaan lanjut terus kepada Pentadbir PCRS Jabatan/ Bahagian masing-masing.</li>
                        <li style="margin-bottom:10px;">Bagi pengurusan data rekod kehadiran <b>bulan Mei 2022 dan sebelumnya</b>, sila gunakan PCRS Versi 1.0. Bagi pengurusan data rekod kehadiran <b>bulan Jun 2022 dan seterusnya</b>, sila gunakan PCRS Versi 2.0.</li>
                        <li style="margin-bottom:10px;">Untuk mengakses Sistem PCRS Versi 1.0, sila klik pautan berikut: <a href="https://pcrsold.melaka.gov.my" target="_blank">https://pcrsold.melaka.gov.my</a></li>
                        <li style="margin-bottom:10px;">Disertakan <b>Manual Pengguna</b> PCRS 2.0 untuk rujukan:</li>
                        
                        	<ul>
                            <li><a href="{{ asset('images/manual/MANUAL_PCRS_-_PENGGUNA_v2.0.pdf') }}" target="_blank">Manual Pengguna</a></li>
                            <li><a href="{{ asset('images/manual/MANUAL_PCRS_-_PENTADBIR_BAHAGIAN_v2.0.pdf') }}" target="_blank">Manual Pentadbir Bahagian</a></li>
                            <li><a href="{{ asset('images/manual/MANUAL_PCRS_-_KETUA_BAHAGIAN_v2.0.pdf') }}" target="_blank">Manual Ketua Bahagian</a></li>
                            </ul>
                        
                        </ol>
                    
                    </div>
                    
                    
                    <br>                    
                    <br>

                    <p>
                    Sekian, Terima Kasih
                    <br><br>
                    Pentadbir Sistem PCRS 2.0
                    <br>
                    <!--ext: 7784-->
                    </p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



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

<script>
    
	$(window).load(function()
	{
		$('#welcomeModal_loadFirst').modal('show');
	});

</script>


<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function() {
			$("#welcomeModal").modal('show');
		}, 500);
	});
</script>


</body>
</html>
