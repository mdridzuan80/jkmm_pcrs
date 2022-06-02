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
	
	
	div.dataTables_wrapper {
        margin-bottom: 3em;
    }
	
</style>

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

 
.format_laporan_bulanan{
 	font-size:10px;
}

.header_laporan_bulanan{
	font-weight:normal;
 	text-transform:uppercase;
}

.hurufbesar{
 	text-transform:uppercase;
}

.text_bold{
 	font-weight: bold;
}

ul.list_acara_bullet{
	margin-left:-1em;
}

ul.list_acara_bullet li span {
    display:block;
    margin-left:-0.5em;
}

/*
ul.list_acara_bullet li::before {
	content: '\25CF';
	color: red;
	font-size: 8px;
	margin-right: 10px;
	position: relative;
	top: -3px;
}
*/

</style>             

</head>
<body>


            <?php
			
			// use of explode
			//$string = "123,46,78,000";
			$bulantahun = explode ("-", $txtTarikh); 
			
			$bulan = $bulantahun[0];
			$tahun = $bulantahun[1];
			
			if($bulan == 'Jan'){
				$bulan_nombor = '01';
				$bulan_malay = 'Januari';
			}
			if($bulan == 'Feb'){
				$bulan_nombor = '02';
				$bulan_malay = 'Februari';
			}
			if($bulan == 'Mar'){
				$bulan_nombor = '03';
				$bulan_malay = 'Mac';
			}
			if($bulan == 'Apr'){
				$bulan_nombor = '04';
				$bulan_malay = 'April';
			}
			if($bulan == 'May'){
				$bulan_nombor = '05';
				$bulan_malay = 'Mei';
			}
			if($bulan == 'Jun'){
				$bulan_nombor = '06';
				$bulan_malay = 'Jun';
			}
			if($bulan == 'Jul'){
				$bulan_nombor = '07';
				$bulan_malay = 'Julai';
			}
			if($bulan == 'Aug'){
				$bulan_nombor = '08';
				$bulan_malay = 'Ogos';
			}
			if($bulan == 'Sep'){
				$bulan_nombor = '09';
				$bulan_malay = 'September';
			}
			if($bulan == 'Oct'){
				$bulan_nombor = '10';
				$bulan_malay = 'Oktober';
			}
			if($bulan == 'Nov'){
				$bulan_nombor = '11';
				$bulan_malay = 'November';
			}
			if($bulan == 'Dec'){
				$bulan_nombor = '12';
				$bulan_malay = 'Disember';
			}
			
			
			//echo $txtTarikh;
            $harilast_dalambulan = cal_days_in_month(CAL_GREGORIAN, $bulan_nombor, $tahun);			
						
			$txtTarikh2 = $tahun.'-'.$bulan_nombor.'-01';
			$txtTarikhHingga2 = $tahun.'-'.$bulan_nombor.'-'.$harilast_dalambulan;
			
			 
			 // Declare two dates
			$date1 = $txtTarikh2;
			$date2 = $txtTarikhHingga2;
			  
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
			
			//$bil_kira = 1;
			
			
			//$department_name = 'Bahagian Teknologi Maklumat Dan Komunikasi (BTMK)';
			$kod_warna = 'Kuning';
			$wbb = 'FLEKSI';

			?>



  
        <?php
		//echo $departmentDisplayId;
		//echo $comSenPPP;
		
		
		//$level_id = $_POST['level_id'];

		//$check = implode(',',$_POST['level_id']);
		
			/*
				$list_nama_selected_finale = '';
				
				foreach($comSenPPP as $list_nama_selected_array) {	
					
					$list_nama_selected_finale = $list_nama_selected_finale.'['.$list_nama_selected_array.']';
				
				}
				*/
		
		//echo $list_nama_selected_finale;
		?>

        <?php
		//foreach ($list_namastaf_department as $data_nama){
		
        foreach ($list_namastaf_department as $data_nama){
			
			//echo $data_nama->anggota_id."<br>";
			//$data_id = '['.$data_nama->anggota_id.']';
			
			//echo $data_nama->nama;
			
			//if(strpos($list_nama_selected_finale, $data_id) !== false){
			
			//echo $data_id;
			//echo $data_nama->anggota_id.' | ';
			//echo $data_nama->nama.' | ';		
			//echo $data_nama->badgenumberr."<br>";
			
		?>
        
        
<page backbottom="25mm" backtop="0mm">
	<page_footer >
	   <table style="width: 100%;">
			 <tr>
					 <td style="padding: 5px; width: 50%">
					 	<table style="width: 100%;">
							<tr>
								<td style="width: 100%;">T/TGN PEGAWAI</td>
							</tr>
							<tr>
								<td style="width: 100%;">&nbsp;</td>
							</tr>
							<tr>
								<td style="width: 100%; border-bottom: 1px dotted black;">&nbsp;</td>
							</tr>
							<tr>
								<td>Tarikh :</td>
							</tr>
						</table>
					 </td>
					 <td style="padding: 5px; width: 50%">
						<table style="width: 100%;">
							<tr>
								<td style="width: 100%;">T/TGN KETUA JABATAN / PENYELIA</td>
							</tr>
							<tr>
								<td style="width: 100%;">&nbsp;</td>
							</tr>
							<tr>
								<td style="width: 100%; border-bottom: 1px dotted black;">&nbsp;</td>
							</tr>
							<tr>
								<td>Tarikh :</td>
							</tr>
						</table>
					 </td>
			 </tr>
	   </table>
	</page_footer>
            
                    
<table style="width:100%; margin-bottom:10px;">
    <tr>
        <td style="width:100%; text-align:center;"><img src="{{ asset('images/jata_melaka_100.png') }}" style="width:70px; height:auto;" /></td>
    </tr>
</table>
	
<div class="format_laporan_bulanan">

<div class="header_laporan_bulanan">
    <div class="text_bold"><?php echo $data_nama->deptname; ?></div>
    <div>Nama: <?php echo $data_nama->nama; ?></div>
    <div>Bulan: <?php echo $bulan_malay.' '.$tahun; ?></div>
    <div>No. Kad: <?php echo $data_nama->badgenumberr; ?></div>
    <div>Kod Warna: <?php echo $kod_warna; ?></div>
    
    
</div>
<br />
            
<table class="biasa" style="font-size:10px; width:100%;" width="100%">

  <thead>
        <tr>
            <th width="10%" style="text-align:center;">TARIKH</th>
            <th width="7%" align="center" style="text-align:center;">WBB</th>
            <th width="10%" align="center" style="text-align:center;">CHECK-IN</th>
            <th width="10%" align="center" style="text-align:center;">CHECK-OUT</th>
            <th width="7%" align="center" style="text-align:center;">JAM</th>
            <th width="10%" align="center" style="text-align:center;">KESALAHAN</th>
            <th width="41%" align="center" style="text-align:center;">CATATAN</th>
            <th width="5%" align="center" style="text-align:center;">TT</th>
        </tr>
  </thead>
  <tbody> 
            
            @foreach ($list_finalattendance as $datetarikh)
            
             @if ($datetarikh->anggota_id == $data_nama->anggota_id)
            
            
            <?php
			
			$hari_malay = '';
				
			if(date("l", strtotime($datetarikh->tarikh)) == 'Sunday'){
				$hari_malay = 'Ahad';
			}
			if(date("l", strtotime($datetarikh->tarikh)) == 'Monday'){
				$hari_malay = 'Isnin';
			}
			if(date("l", strtotime($datetarikh->tarikh)) == 'Tuesday'){
				$hari_malay = 'Selasa';
			}
			if(date("l", strtotime($datetarikh->tarikh)) == 'Wednesday'){
				$hari_malay = 'Rabu';
			}
			if(date("l", strtotime($datetarikh->tarikh)) == 'Thursday'){
				$hari_malay = 'Khamis';
			}
			if(date("l", strtotime($datetarikh->tarikh)) == 'Friday'){
				$hari_malay = 'Jumaat';
			}
			if(date("l", strtotime($datetarikh->tarikh)) == 'Saturday'){
				$hari_malay = 'Sabtu';
			}
			
			$info_lewat = '';
			
			if(strlen($datetarikh->check_in) > 0){								
				$checkin_finale = date("h:i:s A", strtotime($datetarikh->check_in));
				
				if($datetarikh->check_in >= date("Y-m-d", strtotime($datetarikh->tarikh)).' 09:00:59'){
					
					$dateq1_format = date("Y-m-d", strtotime($datetarikh->tarikh)).' 09:00:00';
					$dateq2_format = $datetarikh->check_in;
					
					$dateq1 = new DateTime($dateq1_format);
					$dateq2 = new DateTime($dateq2_format);
					$beza_masaq = $dateq1->diff($dateq2);
					$diffInSecondsq = $beza_masaq->s; //45.
					$diffInMinutesq = $beza_masaq->i; //23.
					$diffInHoursq = $beza_masaq->h; //8.
					//$diffInDaysq = $beza_masaq->d; //21.
					
					$info_lewat = "<span style='color:red;'>"."Lewat ".str_pad($diffInHoursq,2,'0',STR_PAD_LEFT).':'.str_pad($diffInMinutesq,2,'0',STR_PAD_LEFT).':'.str_pad($diffInSecondsq,2,'0',STR_PAD_LEFT)."</span><br>";
				
				}
								
			}else{								
				$checkin_finale = '';				
			}
			
			if(strlen($datetarikh->check_out) > 0){								
				$checkout_finale = date("h:i:s A", strtotime($datetarikh->check_out));				
			}else{								
				$checkout_finale = '';				
			}
			
			//echo cal_days_in_month(CAL_GREGORIAN, 02, 2020);
			
			//$kesalahan_finale = $datetarikh->kesalahan;
			$kesalahan_finale1 = '';
			$kesalahan_finale2 = '';
			$kesalahan_finale3 = '';
			$kesalahan_finale4 = '';
			
			if(strpos($datetarikh->kesalahan, 'NONEIN') !== false){
				$kesalahan_finale1 = "Pg: Tiada rekod"."<br>";
			}
			if(strpos($datetarikh->kesalahan, 'LEWAT') !== false){
				$kesalahan_finale2 = "Pg: Hadir lewat"."<br>";
			}
			if(strpos($datetarikh->kesalahan, 'NONEOUT') !== false){
				$kesalahan_finale3 = "Ptg: Tiada rekod"."<br>";
			}
			if(strpos($datetarikh->kesalahan, 'AWAL') !== false){
				$kesalahan_finale4 = "Ptg: Pulang awal"."<br>";
			}
			
			$kesalahan_finaleALL = $kesalahan_finale1.$kesalahan_finale2.$info_lewat.$kesalahan_finale3.$kesalahan_finale4;
			
			
			$beza_masaALL = '';
			$diffInHours = '';
			$diffInMinutes = '';
			
			if(strlen($datetarikh->check_out) > 0){	
			
			
				$datetarikh_check_in = $datetarikh->check_in;
				$datetarikh_check_out = $datetarikh->check_out;
				
				if(strlen($datetarikh->check_in) == 0){	
					$datetarikh_check_in = date("Y-m-d", strtotime($datetarikh->tarikh)).' 09:00:00';
				}
				
				//echo $datetarikh->check_in;
				
				$date1 = new DateTime($datetarikh_check_in);
				$date2 = new DateTime($datetarikh_check_out);
				$beza_masa = $date1->diff($date2);
				$diffInSeconds = $beza_masa->s; //45.
				$diffInMinutes = $beza_masa->i; //23.
				$diffInHours = $beza_masa->h; //8.
				$diffInDays = $beza_masa->d; //21.
				
				$beza_masaALL = str_pad($diffInHours,2,"0",STR_PAD_LEFT).':'.str_pad($diffInMinutes,2,"0",STR_PAD_LEFT).':'.str_pad($diffInSeconds,2,"0",STR_PAD_LEFT);
			
			}
			
			
			
			
				//$nota_xcukup_9jam = "";
				
				if($diffInHours >= 9){
						
					$nota_xcukup_9jam = "";
					
				}
				
				if($diffInHours < 9){
					
					if($diffInHours == 8){
						
						if($diffInMinutes == 59){
							$nota_xcukup_9jam = "";
						}
						if($diffInMinutes < 59){
							
							if(date("H", strtotime($datetarikh->check_out)) >= 18){
								$nota_xcukup_9jam = "";
							}else{
								$nota_xcukup_9jam = "Kurang 9 jam waktu bekerja";
							}
						}
						
					}
					if($diffInHours < 8){
						
						if($diffInHours == 0){
						
							$nota_xcukup_9jam = "";
							
						}else{
						
							if(date("H", strtotime($datetarikh->check_out)) >= 18){
								$nota_xcukup_9jam = "";
							}else{
								$nota_xcukup_9jam = "Kurang 9 jam waktu bekerja";
							}
						
						}
					}
					
				}
				
				
				
				$tarikh_semasa_loop = date("Y-m-d", strtotime($datetarikh->tarikh));
				$tarikh_semasa_loop_format = $tarikh_semasa_loop.' 00:00:00';
			
			?>
            
            <tr>
                <td>{{ date("d/m/Y", strtotime($datetarikh->tarikh)) }}<br>{{ '('.$hari_malay.')' }}</td>
                <td align="center">{{ $wbb }}</td>
                <td align="center">{{ $checkin_finale }}</td>
				<td align="center">{{ $checkout_finale }}</td>
				<td align="center"><?php echo $beza_masaALL ?></td>
				<td align="center"><?php echo $kesalahan_finaleALL.$nota_xcukup_9jam; ?></td>
				<td>
                
                	    
                      @foreach ($list_cuti as $data_cuti)
                      
                      	@if ($data_cuti->tarikh == $tarikh_semasa_loop_format)
                        
                        	@php
                            
                            	echo 'Cuti AM: '.$data_cuti->perihal;
                            
                            @endphp
                        
                        @endif
                      
                      @endforeach
                      
                      
                      <ul class="list_acara_bullet">
                      @foreach ($list_acara_department as $data_acara)
                        
                        
                        @if (($tarikh_semasa_loop >= date("Y-m-d", strtotime($data_acara->tarikh_mula))) && ($tarikh_semasa_loop <= date("Y-m-d", strtotime($data_acara->tarikh_tamat))) && ($data_nama->anggota_id == $data_acara->anggota_id))
                        
                            
                            @php
                                if($data_acara->flag_kelulusan == 'MOHON'){
                                	$da_statusmohon = 'MOHON';
                                }
                                if($data_acara->flag_kelulusan == 'LULUS'){
                                	$da_statusmohon = 'LULUS';
                                }
                                if($data_acara->flag_kelulusan == 'TOLAK'){
                                	$da_statusmohon = 'TOLAK';
                                }
                                if($data_acara->flag_kelulusan == 'BATAL'){
                                	$da_statusmohon = 'BATAL';
                                }
                            @endphp
                            
                            @if ($data_acara->kategori == 'J')
                            
                            	@php
                                if($data_acara->medan_kesalahan == 'PAGI'){
                                	$da_medan_kesalahan = 'PG';
                                }
                                if($data_acara->medan_kesalahan == 'PETANG'){
                                	$da_medan_kesalahan = 'PTG';
                                }
                                @endphp
                            	
                                <li><span>{{ $data_acara->kategori.' - '.$da_statusmohon.' ('.$da_medan_kesalahan.') - '.$data_acara->keterangan }}</span></li>
                                
                            @endif
                            
                            @if (($data_acara->kategori == 'T') || ($data_acara->kategori == 'C'))
                                <li><span>{{ $data_acara->kategori.' - '.$da_statusmohon.' ('.date("H.i", strtotime($data_acara->tarikh_mula)).' - '.date("H.i", strtotime($data_acara->tarikh_tamat)).') - '.$data_acara->keterangan }}</span></li>
                                
                            @endif
                        
                        @endif
                        
                    
                    @endforeach
                    </ul>
                    
                    
                 </td>
                 
				<td align="center"></td>		
                
            </tr>
            
            @endif
            
            @endforeach 
   
  </tbody>
</table>

</div> 



</page>
  
<!--<div class="html2pdf__page-break"></div> -->
<?php
/*
html2pdf().set({
   pagebreak: {avoid: 'tr'}
});
*/

//protected function _tag_open_PAGE($param){}   

	//}
}
?>

</body>
</html>
