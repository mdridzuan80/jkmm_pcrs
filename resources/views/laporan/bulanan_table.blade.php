<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable_1').DataTable({
            "scrollX": false,
            //"searching": false,
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],

            buttons: [

                'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'

            ]

        });
        $('.dataTables_length').addClass('bs-select');
    });


    $(document).ready(function() {
        $('#datatable_2').DataTable({
            "scrollX": false,
            //"searching": false,
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],

            buttons: [

                'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'

            ]

        });
        $('.dataTables_length').addClass('bs-select');
    });




    $(document).ready(function() {
        $('#datatable_12').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],

            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

<style>
    .table-fixed thead {
        width: 98%;
    }

    .table-fixed tbody {
        height: 200px;
        overflow-y: auto;
        width: 100%;
    }

    .table-fixed thead,
    .table-fixed tbody,
    .table-fixed tr,
    .table-fixed td,
    .table-fixed th {
        display: block;
    }

    .table-fixed tbody td,
    .table-fixed thead>tr>th {
        float: left;
        border-bottom-width: 0;
    }


    table.biasa,
    table.listing {
        border-collapse: collapse;
        border-color: #666666;
        border-width: 1px;
        color: #333333;
    }

    table.biasa th,
    table.listing th {
        background: #333;
        border-color: #262628;
        border-style: solid;
        border-width: 1px;
        color: #FDFDFF;
        font-weight: bold;
        padding: 3px 8px;
        text-transform: uppercase;
    }

    table.biasa tr,
    table.listing tr {
        background-color: #FFFFFF;
    }

    table.biasa tr.even,
    table.listing tr.even {
        background-color: #F5F5F7;
    }

    table.biasa td,
    table.listing td {
        border-color: #D2D2D4;
        border-style: solid;
        border-width: 1px;
        padding: 3px 8px;
    }


    .format_laporan_bulanan {
        font-size: 14px;
    }

    .header_laporan_bulanan {
        font-weight: normal;
        text-transform: uppercase !important;
    }

    .hurufbesar {
        text-transform: uppercase !important;
    }

    .text_bold {
        font-weight: bold !important;
    }

    ul.list_acara_bullet {
        margin-left: -23px !important;
    }

    ul.list_acara_bullet li span {
        display: block;
        margin-left: -0.5em;
    }




    div.column_kesalahan {
        margin-left: 0px;
    }
</style>

<?php

// use of explode
//$string = "123,46,78,000";
$bulantahun = explode('-', $txtTarikh);

$bulan = $bulantahun[0];
$tahun = $bulantahun[1];

if ($bulan == 'Jan') {
    $bulan_nombor = '01';
    $bulan_malay = 'Januari';
}
if ($bulan == 'Feb') {
    $bulan_nombor = '02';
    $bulan_malay = 'Februari';
}
if ($bulan == 'Mar') {
    $bulan_nombor = '03';
    $bulan_malay = 'Mac';
}
if ($bulan == 'Apr') {
    $bulan_nombor = '04';
    $bulan_malay = 'April';
}
if ($bulan == 'May') {
    $bulan_nombor = '05';
    $bulan_malay = 'Mei';
}
if ($bulan == 'Jun') {
    $bulan_nombor = '06';
    $bulan_malay = 'Jun';
}
if ($bulan == 'Jul') {
    $bulan_nombor = '07';
    $bulan_malay = 'Julai';
}
if ($bulan == 'Aug') {
    $bulan_nombor = '08';
    $bulan_malay = 'Ogos';
}
if ($bulan == 'Sep') {
    $bulan_nombor = '09';
    $bulan_malay = 'September';
}
if ($bulan == 'Oct') {
    $bulan_nombor = '10';
    $bulan_malay = 'Oktober';
}
if ($bulan == 'Nov') {
    $bulan_nombor = '11';
    $bulan_malay = 'November';
}
if ($bulan == 'Dec') {
    $bulan_nombor = '12';
    $bulan_malay = 'Disember';
}

//echo $txtTarikh;
$harilast_dalambulan = cal_days_in_month(CAL_GREGORIAN, $bulan_nombor, $tahun);

$txtTarikh2 = $tahun . '-' . $bulan_nombor . '-01';
$txtTarikhHingga2 = $tahun . '-' . $bulan_nombor . '-' . $harilast_dalambulan;

// Declare two dates
$date1 = $txtTarikh2;
$date2 = $txtTarikhHingga2;

// Declare an empty array
$arraydate = [];

// Use strtotime function
$Variable1 = strtotime($date1);
$Variable2 = strtotime($date2);

// Use for loop to store dates into array
// 86400 sec = 24 hrs = 60*60*24 = 1 day
for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += 86400) {
    $Store = date('Y-m-d', $currentDate);
    $arraydate[] = $Store;
}

//$bil_kira = 1;

//$department_name = 'Bahagian Teknologi Maklumat Dan Komunikasi (BTMK)';
$kod_warna = 'Kuning';
$wbb = 'FLEKSI';
$count_wbb_puasa_mengandung = 0;

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

<?php

foreach ($list_wbb_puasa_mengandung as $list_wbb_puasa_mengandungku_count) {
    $count_wbb_puasa_mengandung++;
}
?>


<div style="background-color:rgba(204,204,204,0.5); width:100%; height:2px; margin-bottom:20px;"></div>

<table style="width:100%">
    <tr>
        <td style="width:100%; text-align:center;"><img src="{{ asset('images/jata_melaka_100.png') }}"
                style="width:80px; height:auto;" /></td>
    </tr>
</table>


<div class="format_laporan_bulanan">

    <br />
    <div class="header_laporan_bulanan">
        <div class="text_bold"><?php echo $data_nama->deptname; ?></div>
        <div>Nama: <?php echo $data_nama->nama; ?></div>
        <div>Bulan: <?php echo $bulan_malay . ' ' . $tahun; ?></div>
        <div>No. Kad: <?php echo $data_nama->badgenumberr; ?></div>
        <div>Kod Warna: <?php echo $kod_warna; ?></div>


    </div>
    <br />

    <table class="table table-hover table-striped biasa" style="font-size: 14px !important;">
        <thead>
            <tr>
                <th width="13%" style="text-align:center;">TARIKH</th>
                <th width="6%" align="center" style="text-align:center;">WBB</th>
                <th width="13%" align="center" style="text-align:center;">CHECK-IN</th>
                <th width="13%" align="center" style="text-align:center;">CHECK-OUT</th>
                <th width="7%" align="center" style="text-align:center;">JAM</th>
                <th width="13%" align="center" style="text-align:center;">KESALAHAN</th>
                <th align="center" style="text-align:center;">CATATAN</th>
                <th width="5%" align="center" style="text-align:center;">TT</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($list_finalattendance as $datetarikh)
                <?php
                $tarikh_semasa_loop = date('Y-m-d', strtotime($datetarikh->tarikh));
                $tarikh_semasa_loop_format = $tarikh_semasa_loop . ' 00:00:00';
                ?>

                @if ($datetarikh->anggota_id == $data_nama->anggota_id)
                    <?php
                    
                    $hari_malay = '';
                    
                    if (date('l', strtotime($datetarikh->tarikh)) == 'Sunday') {
                        $hari_malay = 'Ahad';
                    }
                    if (date('l', strtotime($datetarikh->tarikh)) == 'Monday') {
                        $hari_malay = 'Isnin';
                    }
                    if (date('l', strtotime($datetarikh->tarikh)) == 'Tuesday') {
                        $hari_malay = 'Selasa';
                    }
                    if (date('l', strtotime($datetarikh->tarikh)) == 'Wednesday') {
                        $hari_malay = 'Rabu';
                    }
                    if (date('l', strtotime($datetarikh->tarikh)) == 'Thursday') {
                        $hari_malay = 'Khamis';
                    }
                    if (date('l', strtotime($datetarikh->tarikh)) == 'Friday') {
                        $hari_malay = 'Jumaat';
                    }
                    if (date('l', strtotime($datetarikh->tarikh)) == 'Saturday') {
                        $hari_malay = 'Sabtu';
                    }
                    
                    $info_lewat = '';
                    $tentukan_papar_ke_x = 'PAPAR';
                    $color_row = '#ffffff';
                    $status_cuti_umum = 'tidak';
                    
                    ?>

                    <?php
                    
                    foreach ($list_cuti as $data_cuti_check) {
                        if ($data_cuti_check->tarikh == $tarikh_semasa_loop_format) {
                            $status_cuti_umum = 'ya';
                        }
                    }
                    
                    ?>


                    <?php
                    
                    if (strlen($datetarikh->check_in) > 0) {
                        $checkin_finale = date('h:i:s A', strtotime($datetarikh->check_in));
                    
                        if ($datetarikh->check_in >= date('Y-m-d', strtotime($datetarikh->tarikh)) . ' 09:00:59') {
                            $dateq1_format = date('Y-m-d', strtotime($datetarikh->tarikh)) . ' 09:00:00';
                            $dateq2_format = $datetarikh->check_in;
                    
                            $dateq1 = new DateTime($dateq1_format);
                            $dateq2 = new DateTime($dateq2_format);
                            $beza_masaq = $dateq1->diff($dateq2);
                            $diffInSecondsq = $beza_masaq->s; //45.
                            $diffInMinutesq = $beza_masaq->i; //23.
                            $diffInHoursq = $beza_masaq->h; //8.
                            //$diffInDaysq = $beza_masaq->d; //21.
                    
                            if (($status_cuti_umum = 'tidak') || $hari_malay != 'Sabtu' || $hari_malay != 'Ahad') {
                                $info_lewat = "<span style='color:red;'>" . 'Lewat ' . str_pad($diffInHoursq, 2, '0', STR_PAD_LEFT) . ':' . str_pad($diffInMinutesq, 2, '0', STR_PAD_LEFT) . ':' . str_pad($diffInSecondsq, 2, '0', STR_PAD_LEFT) . '</span><br>';
                            }
                        }
                    } else {
                        $checkin_finale = '';
                    }
                    
                    if (strlen($datetarikh->check_out) > 0) {
                        $checkout_finale = date('h:i:s A', strtotime($datetarikh->check_out));
                    } else {
                        $checkout_finale = '';
                    }
                    
                    //echo cal_days_in_month(CAL_GREGORIAN, 02, 2020);
                    
                    //$kesalahan_finale = $datetarikh->kesalahan;
                    $kesalahan_finale1 = '';
                    $kesalahan_finale2 = '';
                    $kesalahan_finale3 = '';
                    $kesalahan_finale4 = '';
                    $check_dahadax = 0;
                    $kesalahan_finaleALL = '';
                    
                    if (($status_cuti_umum = 'tidak') || $hari_malay != 'Sabtu' || $hari_malay != 'Ahad') {
                        if (strpos($datetarikh->kesalahan, 'NONEIN') !== false) {
                            $kesalahan_finale1 = "<div class='column_kesalahan'>Pg: Tiada rekod</div>";
                        }
                        if (strpos($datetarikh->kesalahan, 'LEWAT') !== false) {
                            $kesalahan_finale2 = "<div class='column_kesalahan'>Pg: Hadir lewat</div>";
                        }
                        if (strpos($datetarikh->kesalahan, 'NONEOUT') !== false) {
                            $kesalahan_finale3 .= "<div class='column_kesalahan'>Ptg: Tiada rekod</div>";
                        }
                        if (strpos($datetarikh->kesalahan, 'AWAL') !== false) {
                            $kesalahan_finale4 .= "<div class='column_kesalahan'>Ptg: Pulang awal</div>";
                        }
                    }
                    
                    if (($status_cuti_umum = 'tidak') || $hari_malay != 'Sabtu' || $hari_malay != 'Ahad') {
                        $kesalahan_finaleALL = $kesalahan_finale1 . $kesalahan_finale2 . $info_lewat . $kesalahan_finale3 . $kesalahan_finale4;
                    }
                    
                    $beza_masaALL = '';
                    $diffInHours = '';
                    $diffInMinutes = '';
                    
                    if (strlen($datetarikh->check_out) > 0) {
                        $datetarikh_check_in = $datetarikh->check_in;
                        $datetarikh_check_out = $datetarikh->check_out;
                    
                        if (strlen($datetarikh->check_in) == 0) {
                            $datetarikh_check_in = date('Y-m-d', strtotime($datetarikh->tarikh)) . ' 09:00:00';
                        }
                    
                        //echo $datetarikh->check_in;
                    
                        $date1 = new DateTime($datetarikh_check_in);
                        $date2 = new DateTime($datetarikh_check_out);
                        $beza_masa = $date1->diff($date2);
                        $diffInSeconds = $beza_masa->s; //45.
                        $diffInMinutes = $beza_masa->i; //23.
                        $diffInHours = $beza_masa->h; //8.
                        $diffInDays = $beza_masa->d; //21.
                    
                        $beza_masaALL = str_pad($diffInHours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($diffInMinutes, 2, '0', STR_PAD_LEFT) . ':' . str_pad($diffInSeconds, 2, '0', STR_PAD_LEFT);
                    }
                    
                    ?>



                    <?php
                    
                    if ($hari_malay != 'Sabtu' || $hari_malay != 'Ahad' || $status_cuti_umum == 'tidak') {
                        //$nota_xcukup_9jam = "";
                    
                        if ($diffInHours >= 9) {
                            $nota_xcukup_9jam = '';
                        }
                    
                        if ($diffInHours < 9) {
                            if ($diffInHours == 8) {
                                if ($diffInMinutes == 59) {
                                    $nota_xcukup_9jam = '';
                                }
                                if ($diffInMinutes < 59) {
                                    if (date('H', strtotime($datetarikh->check_out)) >= 18) {
                                        $nota_xcukup_9jam = '';
                                    } else {
                                        $nota_xcukup_9jam = 'Kurang 9 jam waktu bekerja';
                                    }
                                }
                            }
                            if ($diffInHours < 8) {
                                if ($diffInHours == 0) {
                                    $nota_xcukup_9jam = '';
                                } else {
                                    if (date('H', strtotime($datetarikh->check_out)) >= 18) {
                                        $nota_xcukup_9jam = '';
                                    } else {
                                        $nota_xcukup_9jam = 'Kurang 9 jam waktu bekerja';
                                    }
                                }
                            }
                        }
                    }
                    if ($hari_malay == 'Sabtu' || $hari_malay == 'Ahad' || $status_cuti_umum == 'ya') {
                        $nota_xcukup_9jam = '';
                    }
                    
                    $tarikh_semasa_loop = date('Y-m-d', strtotime($datetarikh->tarikh));
                    $tarikh_semasa_loop_format = $tarikh_semasa_loop . ' 00:00:00';
                    
                    if ($hari_malay == 'Sabtu' || $hari_malay == 'Ahad') {
                        $color_row = '#ececec';
                    }
                    
                    ?>

                    <tr <?php if ($hari_malay == 'Sabtu' || $hari_malay == 'Ahad') {
                        echo ' style="background-color: #fffee9;"';
                    } ?>>
                        <td>{{ date('d/m/Y', strtotime($datetarikh->tarikh)) . ' (' . $hari_malay . ')' }}</td>

                        <td align="center">


                            @foreach ($list_wbb_puasa_mengandung as $list_wbb_puasa_mengandungku)
                                @if ($list_wbb_puasa_mengandungku->anggota_id == $data_nama->anggota_id && (($list_wbb_puasa_mengandungku->tkhmula <= $tarikh_semasa_loop_format && $list_wbb_puasa_mengandungku->tkhtamat >= $tarikh_semasa_loop_format) || ($list_wbb_puasa_mengandungku->tkh_mula <= $tarikh_semasa_loop_format && $list_wbb_puasa_mengandungku->tkh_tamat >= $tarikh_semasa_loop_format)))
                                    <?php
                                    
                                    if ($list_wbb_puasa_mengandungku->jenis == 'PUASA') {
                                        $wbb_jenis = 'FLEKSI RAMADAN';
                                    }
                                    if ($list_wbb_puasa_mengandungku->jenis == 'MENGANDUNG') {
                                        $wbb_jenis = 'FLEKSI MENGANDUNG';
                                    }
                                    
                                    ?>

                                    {{ $wbb_jenis }}

                                    <?php $tentukan_papar_ke_x = 'TAK'; ?>
                                @endif
                            @endforeach

                            <?php if($tentukan_papar_ke_x == 'PAPAR'){ ?>

                            @foreach ($list_wbb_bulanan as $list_wbb_bulananku)
                                @if ($list_wbb_bulananku->anggota_id == $data_nama->anggota_id && $list_wbb_bulananku->tkh_mula <= $tarikh_semasa_loop_format && $list_wbb_bulananku->tkh_tamat >= $tarikh_semasa_loop_format)
                                    {{ $list_wbb_bulananku->name }}
                                @endif
                            @endforeach

                            <?php } ?>

                        </td>

                        <td align="center">{{ $checkin_finale }}</td>
                        <td align="center">{{ $checkout_finale }}</td>
                        <td align="center"><?php echo $beza_masaALL; ?></td>
                        <td align="center"><?php echo $kesalahan_finaleALL . $nota_xcukup_9jam; ?></td>
                        <td>


                            @foreach ($list_cuti as $data_cuti)
                                @if ($data_cuti->tarikh == $tarikh_semasa_loop_format)
                                    @php
                                        
                                        echo 'Cuti AM: ' . $data_cuti->perihal;
                                        
                                    @endphp
                                @endif
                            @endforeach

                            <ul class="list_acara_bullet">
                                @foreach ($list_acara_department as $data_acara)
                                    @if ($tarikh_semasa_loop >= date('Y-m-d', strtotime($data_acara->tarikh_mula)) && $tarikh_semasa_loop <= date('Y-m-d', strtotime($data_acara->tarikh_tamat)) && $data_nama->anggota_id == $data_acara->anggota_id)
                                        @php
                                            if ($data_acara->flag_kelulusan == 'MOHON') {
                                                $da_statusmohon = 'MOHON';
                                            }
                                            if ($data_acara->flag_kelulusan == 'LULUS') {
                                                $da_statusmohon = 'LULUS';
                                            }
                                            if ($data_acara->flag_kelulusan == 'TOLAK') {
                                                $da_statusmohon = 'TOLAK';
                                            }
                                            if ($data_acara->flag_kelulusan == 'BATAL') {
                                                $da_statusmohon = 'BATAL';
                                            }
                                        @endphp

                                        @if ($data_acara->kategori == 'J')
                                            @php
                                                if ($data_acara->medan_kesalahan == 'PAGI') {
                                                    $da_medan_kesalahan = 'PG';
                                                }
                                                if ($data_acara->medan_kesalahan == 'PETANG') {
                                                    $da_medan_kesalahan = 'PTG';
                                                }
                                            @endphp

                                            <li><span>{{ $data_acara->kategori . ' - ' . $da_statusmohon . ' (' . $da_medan_kesalahan . ') - ' . $data_acara->keterangan }}</span>
                                            </li>
                                        @endif

                                        @if ($data_acara->kategori == 'T' || $data_acara->kategori == 'C')
                                            <li><span>{{ $data_acara->kategori . ' - ' . $da_statusmohon . ' (' . date('H.i', strtotime($data_acara->tarikh_mula)) . ' - ' . date('H.i', strtotime($data_acara->tarikh_tamat)) . ') - ' . $data_acara->keterangan }}</span>
                                            </li>
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



<?php
	//}
}
?>


<!--
<?php
//$kirabil = 1;
?>

<br /><br />
<?php
/* 
foreach ($list_finalattendance as $datetarikh2){

   
    if(strlen($datetarikh2->check_in) > 0){								
        $checkin_finale = $datetarikh2->check_in.'('.$datetarikh2->anggota_id.')';				
    }else{								
        $checkin_finale = 'CI'.'('.$datetarikh2->anggota_id.')';				
    }
    
    if(strlen($datetarikh2->check_out) > 0){								
        $checkout_finale = $datetarikh2->check_out.'('.$datetarikh2->anggota_id.')';				
    }else{								
        $checkout_finale = 'CO'.'('.$datetarikh2->anggota_id.')';				
    }
*/

//echo $kirabil.') '.$checkin_finale.' | '.$checkout_finale;
?>
    <br />
    
    <?php
    //$kirabil++
    
    //}
    ?>
   
-->
