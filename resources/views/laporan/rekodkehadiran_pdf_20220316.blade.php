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
</style>
</head>
<body>
    <table id="datatable_1" class="table table-hover table-striped" style="font-size: 14px !important;">
  <tbody>
  
            <tr>
                <th width="5%" align="center">#</th>
                <th>Nama</th>
                <th width="10%" align="center">Tarikh</th>
                <th width="10%" align="center">T & M</th>
                <th width="10%" align="center">Data2</th>
                <th width="10%">Jenis Punch</th>
                <th width="10%">Mesin</th>
            </tr>
            
             @foreach ($list_checkinout as $l_rekodkehadiran)
              
              @php
                if($l_rekodkehadiran->checktype == 'I'){
                    $l_rekodkehadiran_jenispunch = 'In';
                }
                elseif($l_rekodkehadiran->checktype == 'O'){
                    $l_rekodkehadiran_jenispunch = 'Out';
                }
                elseif($l_rekodkehadiran->checktype == 'i'){
                    $l_rekodkehadiran_jenispunch = 'Keluar Site';
                }
                elseif($l_rekodkehadiran->checktype == '1'){
                    $l_rekodkehadiran_jenispunch = 'Balik Site';
                }
                else{
                    $l_rekodkehadiran_jenispunch = '-';
                }
            @endphp
            
            
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $l_rekodkehadiran->namaa }}</td>
                <!--<td>{{ (Auth::user()->xtraAnggota) ? Auth::user()->xtraAnggota->nama : Auth::user()->name }}</td>-->
                <td>{{ date("l d/m/Y", strtotime($l_rekodkehadiran->checktime)) }}</td>
                <td>
                
                <?php 
                /*
                if($val['chkinout']) {
                    foreach($val['chkinout'] as $d) {
                        echo(date("g:i:s a", strtotime($d['checkinout'])) ."<br/>");
                    }
                }
                */
                ?>
                
                </td>
                <td>{{ $l_rekodkehadiran->checktime }}</td>
                <td>{{ $l_rekodkehadiran_jenispunch }}</td>
                <td>{{ $l_rekodkehadiran->sensorid }}</td>
            </tr>
            
              <?php //echo date("l d/m/Y", strtotime($l_rekodkehadiran->checktime))?>
                
            @endforeach
            
 
       
   
  </tbody>
</table>

</body>
</html>
