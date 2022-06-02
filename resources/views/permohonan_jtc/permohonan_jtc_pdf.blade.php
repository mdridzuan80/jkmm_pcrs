<!DOCTYPE html>
<html lang="en">
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
  
<!--datatable!-->
<link rel="stylesheet" href="{{ asset('datatable/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatable/css/buttons.dataTables.min.css') }}">

<!--tutup datatable !-->
  

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
	
	
	table.biasa, table.listing {
		border-collapse: collapse;
		border-color: #666666;
		border-width: 1px;
		color: #333333;
	}
	table.biasa th, table.listing th {
		background: #333;
		border-color: #262628;
		border-style: solid;
		border-width: 1px;
		color: #FDFDFF;
		font-weight: bold;
		padding: 3px 8px;
		text-transform: uppercase;
	}
	table.biasa tr, table.listing tr {
		background-color: #FFFFFF;
	}
	table.biasa tr.even, table.listing tr.even {
		background-color: #F5F5F7;
	}
	table.biasa td, table.listing td {
		border-color: #D2D2D4;
		border-style: solid;
		border-width: 1px;
		padding: 3px 8px;
	}
	
</style>


</head>
<body>

<?php

if($kategori_acara == '0'){
	$kategori_acara_format = 'Justifikasi, Timeslip & Catatan';
}
if($kategori_acara == 'J'){
	$kategori_acara_format = 'Justifikasi';
}
if($kategori_acara == 'T'){
	$kategori_acara_format = 'Timeslip';
}
if($kategori_acara == 'C'){
	$kategori_acara_format = 'Catatan';
}


?>
            

<table width="100%">
    	<tr>
        	<td width="100%" style="font-weight:bold; padding-bottom:15px;">SENARAI PERMOHONAN JUSTIFIKASI, TIMESLIP & CATATAN</td>
        </tr>
        <tr>
        	<td width="100%" style="font-size:12px;">KATEGORI: <?php echo $kategori_acara_format; ?></td>
        </tr>
        <tr>
        	<td width="100%" style="font-size:12px;">TARIKH: <?php echo $txtTarikhMula.' hingga '.$txtTarikhAkhir; ?></td>
        </tr>
</table>
<br>            


<?php $nombor = 1; ?>
<table id="datatable_1" class="table table-hover table-striped biasa" width="100%" style="width:100%; font-size: 10px !important;">
  <thead>
  
            <tr style="font-size:10px;">
                <th style="text-align:center;">#</th>
                <th>Nama</th>
                <th style="text-align:center;">Tarikh & Masa</th>
                <th style="text-align:center;">Kategori</th>
                <th style="text-align:center;">Kesalahan<br />Justifikasi</th>
                <th>Perkara</th>
                <th>Keterangan</th>
                <th style="text-align:center;">Status</th>
            </tr>
    </thead>
    <tbody>        
    <?php
    if($permohonan->count()){
    ?>
        @foreach ($permohonan as $justifikasi)
            
            <?php
                if($justifikasi->kategori == 'J'){
                    $justifikasi_kategori = 'Justifikasi';
                }
                if($justifikasi->kategori == 'T'){
                    $justifikasi_kategori = 'Timeslip';
                }
                if($justifikasi->kategori == 'C'){
                    $justifikasi_kategori = 'Catatan';
                }
           
                //dd($justifikasi);
                
               if($justifikasi->tarikh_mula->format('d-M-Y') == $justifikasi->tarikh_tamat->format('d-M-Y')){
                    $justifikasi_tarikh_finale = $justifikasi->tarikh_mula->format('d.m.Y').' ('.$justifikasi->tarikh_mula->format('H:i').' - '.$justifikasi->tarikh_tamat->format('H:i').')';
                }
                
                if($justifikasi->tarikh_mula->format('d-M-Y') != $justifikasi->tarikh_tamat->format('d-M-Y')){
                    
                    $justifikasi_tarikh_finale = $justifikasi->tarikh_mula->format('d.m.Y').' - '.$justifikasi->tarikh_tamat->format('d.m.Y').' ('.$justifikasi->tarikh_mula->format('H:i').' - '.$justifikasi->tarikh_tamat->format('H:i').')';
                }
                
                
                if($justifikasi->medan_kesalahan == 'PAGI'){
                    $justifikasi_waktu = ' (Pg)'; 
                    
                    if(strpos($justifikasi->acara_finalAttendance->kesalahan, 'NONEIN') !== false){
                        $jenis_kesalahan = 'Tidak Punch-In';                                    
                    }
                    if(strpos($justifikasi->acara_finalAttendance->kesalahan, 'LEWAT') !== false){
                        $jenis_kesalahan = 'Hadir Lewat';                                    
                    }
                                                   
                }
                elseif($justifikasi->medan_kesalahan == 'PETANG'){
                    $justifikasi_waktu =  ' (Ptg)'; 
                    
                    if(strpos($justifikasi->acara_finalAttendance->kesalahan, 'NONEOUT') !== false){
                        $jenis_kesalahan = 'Tidak Punch-Out';                                    
                    }
                    if(strpos($justifikasi->acara_finalAttendance->kesalahan, 'AWAL') !== false){
                        $jenis_kesalahan = 'Pulang Awal';                                    
                    }                               
                }else{
                    $justifikasi_waktu = '';
                    $jenis_kesalahan = '-';                                 
                }


            
                if($justifikasi->flag_kelulusan == 'MOHON'){
                    $status_permohonan = 'MOHON';
                    $color_status = '#333';
                }
                if($justifikasi->flag_kelulusan == 'LULUS'){
                    $status_permohonan = 'DILULUSKAN';
                    $color_status = 'green';
                }
                if($justifikasi->flag_kelulusan == 'TOLAK'){
                    $status_permohonan = 'DITOLAK';
                    $color_status = 'red';
                }
                if($justifikasi->flag_kelulusan == 'BATAL'){
                    $status_permohonan = 'DIBATALKAN';
                    $color_status = 'blue';
                }
          
            
            $datemula = date("Y-m-d H:i:s", strtotime($justifikasi->tarikh_mula));
            $datetamat = date("Y-m-d H:i:s", strtotime($justifikasi->tarikh_tamat));
            
            ?>
            
            <tr style="font-size:10px;">
                <td style="width:3%;"><?php echo $nombor++; ?>.</td>
                <td style="width:15%;">{{ $justifikasi->acara_userinfo->nama }}</td>
                <td style="width:8%;" align="center"><?php echo $justifikasi_tarikh_finale; ?></td>
                <td style="width:8%;" align="center">{{ $justifikasi_kategori.$justifikasi_waktu }}</td>                                
                <td style="width:8%;" align="center">{{ $jenis_kesalahan }}</td>                                                                
                <td style="width:12%;">{{ $justifikasi->perkara }}</td>
                <td style="width:25%;">{{ $justifikasi->keterangan }}</td>
                <td style="width:8%;" align="center" style="color:<?php echo $color_status; ?>;">{{ $status_permohonan }}</td>
            </tr>
            
        @endforeach
    <?php
    }else{
    ?>
        <tr align="center"><td colspan="9">Tiada permohonan</td></tr>
    <?php
    }
    ?>
  </tbody>
</table>




</body>
</html>
