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


<?php
			
			 
		 // Declare two dates
		$date1 = $txtTarikh;
		$date2 = $txtTarikhHingga;
		  
		// Declare an empty array
		$arraydate = array();
		  
		// Use strtotime function
		$Variable1 = strtotime($date1);
		$Variable2 = strtotime($date2);
		  
		// Use for loop to store dates into array
		// 86400 sec = 24 hrs = 60*60*24 = 1 day
		for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
											  
		$Store = date('Y-m-d', $currentDate);
		$arraydate[] = $Store;
		
		}
		
		$bil_kira = 1;
	
?>

</head>
<body>


            

<table width="100%">
    	<tr>
        	<td width="100%">LAPORAN HARIAN</td>
        </tr>
</table>
<br>            
<table id="datatable_1" class="table table-hover table-striped biasa" width="100%" style="width:100%; font-size: 14px !important;">
  <thead>
        <tr>
            <th align="center">#</th>
            <th>Nama</th>
            <th align="center">Tarikh</th>
            <th align="center">Check-In</th>
            <th align="center">Check-Out</th>
        </tr>
  </thead>
  <tbody>   
        

        
        
        @foreach ($list_namastaf_department as $data_nama)
            
            @foreach ($arraydate as $datetarikh)
            
            <?php
			if(date("l", strtotime($datetarikh)) == 'Sunday'){
				$hari_malay = 'Ahad';
			}
			if(date("l", strtotime($datetarikh)) == 'Monday'){
				$hari_malay = 'Isnin';
			}
			if(date("l", strtotime($datetarikh)) == 'Tuesday'){
				$hari_malay = 'Selasa';
			}
			if(date("l", strtotime($datetarikh)) == 'Wednesday'){
				$hari_malay = 'Rabu';
			}
			if(date("l", strtotime($datetarikh)) == 'Thursday'){
				$hari_malay = 'Khamis';
			}
			if(date("l", strtotime($datetarikh)) == 'Friday'){
				$hari_malay = 'Jumaat';
			}
			if(date("l", strtotime($datetarikh)) == 'Saturday'){
				$hari_malay = 'Sabtu';
			}
			?>
            
            <tr>
                <td style="width:5%;" align="center"><?php echo $bil_kira++; ?>.</td>
                <td style="width:43%;">
                            
                     {{ $data_nama->nama }}
                                
                </td>
                <td style="width:22%;" align="center">{{ $hari_malay.', '.date("d/m/Y", strtotime($datetarikh)) }}</td>
                        
				   <?php
                   $array = array();
                    foreach($list_checkinout as $data_checkinout) {
                    
                       //$array = $array2[];
                       if ((strpos($data_checkinout->checktime, date("Y-m-d", strtotime($datetarikh))) !== false) AND ($data_nama->anggota_id == $data_checkinout->userid)){							
                         $array[] = $data_checkinout->checktime;                        
                        }						   
                    }
                    
                    if(count($array) > 0){
                        //$array  = array("dog", "rabbit", "horse", "rat", "cat");
                        foreach($array as $index => $data2) {
                        
                                if (($index === array_key_first($array))){
                                ?>
                                <td style="width:15%;" align="center">
                                <?php
                                    echo date("h:i:s A", strtotime($data2)); // output
                                ?>
                                </td>
                                <?php
                                }
                                
                                if (($index === array_key_last($array))){
                                ?>
                                <td style="width:15%;" align="center">
                                <?php
                                    echo date("h:i:s A", strtotime($data2)); // output
                                ?>
                                </td>
                                <?php
                                }
                            
                        }
                    }else{
                        ?>
                        <td style="width:15%;" align="center"></td>
                        <td style="width:15%;" align="center"></td>
                        <?php
                            
                        }
                   
                    ?>
            </tr>
            
            @endforeach 
    
        @endforeach
   
  </tbody>
</table>

</body>
</html>
