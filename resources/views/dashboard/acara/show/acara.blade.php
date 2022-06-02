@inject('Utility', 'App\Utility')
@inject('Kehadiran', 'App\Kehadiran')
@inject('Justifikasi', 'App\Repositories\Justifikasi')




<?php 

		
	//echo $papauu;            
	$check_punchin = 0;
	$check_punchout = 0;
	//$kira_total = 0;
	//$paparlah = 'oitttt!!!';
	$nmbr = 1;
	
?>





<div class="table-responsive">


    

    @foreach ($events as $event)

<?php
$waktudatang = 0;
$waktubalik = 0;
$waktudatang_data = '';
$waktubalik_data = '';
//$waktudatang = '';
//$masa_balik_9jam = '';
//$masa_balik_9jam = 90000 + 90000;



//$waktudatang_data = (preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0]) ? explode(':', preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0], 2)[1] : explode(':', preg_split('/\r\n|\r|\n/', $Utility::array2object($event)->title)[0], 2)[1];
//$waktudatang_data = (int)$waktudatang_data;

//$waktubalik_data = (isset(preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[1])) ? explode(':', preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[1], 2)[1] : explode(':', preg_split('/\r\n|\r|\n/', $Utility::array2object($event)->title)[1], 2)[1];
//$waktubalik_data = (int)$waktubalik_data;


if($waktudatang_data == '-'){
	$waktudatang == '090000';
}else{
	$waktudatang = date("His", strtotime($waktudatang_data));
}

if($waktubalik_data == '-'){
	$waktubalik == $waktudatang + '090000';
}else{
	$waktubalik = date("His", strtotime($waktubalik_data));
}



?>
<?php
//if($waktudatang == NULL){}
?>



	@foreach ($list_acara_individu_ikuttarikh as $list_acara_individu_ikuttarikhKU)
    
    	<?php
		
		/**/
		//echo $tarikh;		
		$tarikh_mula = $list_acara_individu_ikuttarikhKU->tarikh_mula;
		$tarikh_tamat = $list_acara_individu_ikuttarikhKU->tarikh_tamat;
		
		$status_permohonan = $list_acara_individu_ikuttarikhKU->flag_kelulusan;
		
		$tarikh_mula_time = $list_acara_individu_ikuttarikhKU->tarikh_mula_time;
		$tarikh_tamat_time = $list_acara_individu_ikuttarikhKU->tarikh_tamat_time;
		
		//$masa_balik_9jam = $waktubalik;
		
		
		
		//echo $nmbr++.') '.$tarikh.' || '.$tarikh_mula.' | '.$tarikh_tamat.' || '.$masa_balik_9jam."<br>";
		
		if(($tarikh_mula_time <= '090000') && ($tarikh_tamat_time >= '090000')){
			$check_punchin++;
		}
		
		//if(){}
		//if(($tarikh_mula_time <= '180000') && ($tarikh_tamat_time >= '180000')){
		if(($tarikh_mula_time <= $waktubalik) && ($tarikh_tamat_time >= $waktubalik)){
			$check_punchout++;
		}
		
		
		//echo $masa_balik_9jam;
		
		?>
    
    @endforeach
    
    
    <?php
	
	
	//echo '< '.$check_punchin.' >< '.$check_punchout.' >';
	?> 





        
        @if ($event instanceof App\Cuti)
        <div class="callout callout-warning" title="Cuti Umum">
            <h4>CUTI UMUM : {{ $event->title }}</h4>
        </div>
        @endif
        
       
       
       
        

        @if ($tarikh->lessThanOrEqualTo(today()) && ($event instanceof App\FinalAttendance || $event instanceof App\Kehadiran || gettype($event) == 'array'))
            
            
            
            
            @if ($event['table_name'] === 'current')
            
            
           
        
                
            
            
            
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">CHECK-IN/ OUT</h3>                    
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-body no-padding">
                        <table class="table table-bordered">
                            <tr>
                                <th>CHECK-IN</th>
                                <th>CHECK-OUT</th>
                            </tr>
                            <tr>
                                <td>{{ (preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0]) ? explode(':', preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0], 2)[1] : explode(':', preg_split('/\r\n|\r|\n/', $Utility::array2object($event)->title)[0], 2)[1] }}</td>
                                <td></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            @else
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">CHECK-IN/ OUT</h3>                    
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-body no-padding">
                        <table class="table table-bordered">
                            <tr>
                                <th>CHECK-IN</th>
                                <th>CHECK-OUT</th>
                            </tr>
                            <tr>
                                <td>{{ (preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0]) ? explode(':', preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0], 2)[1] : explode(':', preg_split('/\r\n|\r|\n/', $Utility::array2object($event)->title)[0], 2)[1] }}</td>
                                <td>{{ (isset(preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[1])) ? explode(':', preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[1], 2)[1] : explode(':', preg_split('/\r\n|\r|\n/', $Utility::array2object($event)->title)[1], 2)[1] }}</td>
                            </tr>

                            @php
                                $kesalahan = json_decode($event->kesalahan, true);
                                $pagi = $event->justifikasi->where('medan_kesalahan', $Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI)->first();
                                $petang = $event->justifikasi->where('medan_kesalahan', $Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG)->first();
                            @endphp
                            
                            @if ($event->tatatertib_flag == $Kehadiran::FLAG_TATATERTIB_TUNJUK_SEBAB)
                            
                                <tr>
                                    
                                    <?php if($check_punchin == 0){ ?>
                                    <td style="width: 50%;">
                                        @if (!$pagi && $Utility::kesalahanCheckIn($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                            <form id="frm-mohon-justifikasi-pagi" class="form-horizontal">
                                                <input type="hidden" name="txt-final-attendance-id" value="{{ $event->id }}">
                                                <input type="hidden" name="txt-tarikh" class="txt-tarikh">
                                                <input type="hidden" name="txt-medan-kesalahan" value="{{ $Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI }}">

                                                @if (!$petang && sizeof($kesalahan) == 2)
                                                    <div class="col-sm-12">
                                                        <input type="checkbox" name="chk-sama-petang" id="chk-sama-petang" value="SAMA">
                                                        Justifikasi sama untuk kedua-dua kesalahan
                                                    </div>
                                                @endif
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" name="txt-justifikasi" id="txt-justifikasi-pagi" cols="30" rows="10"></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button id="btn-justifikasi-pagi" class="btn btn-justifikasi btn-primary btn-flat" type="submit"><i class="fa fa-send "></i> Simpan Justifikasi {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckIn($event->kesalahan)] }} </button>
                                                </div>
                                            </form>
                                        @else
                                            @if ($Utility::kesalahanCheckIn($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                                <div>Kesalahan : {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckIn($event->kesalahan)] }}</div>
                                                <div class="show-read-more">Alasan : {{ optional($pagi)->keterangan }}  </div>
                                                <div>Status : {{ optional($pagi)->flag_kelulusan }}</div>
                                                
                                                <!--
                                                <br> 
                                                                                                
                                                <button type="button" class="btn btn-danger pull-left btn-hapus-acara" data-id="{{ optional($petang)->id }}" ><span class="glyphicon glyphicon-trash"></span> Hapus</button>
                                                -->
                                                
                                            @endif
                                        @endif
                                    
                                    </td>
                                    <?php }else{ ?>                                    
                                    <td style="width: 50%;"></td>
                                    <?php } ?>
                                    
                                    <?php if($check_punchout == 0){ ?>
                                    <td style="width: 50%;">
                                        @if (!$petang && $Utility::kesalahanCheckOut($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                            <form id="frm-mohon-justifikasi-petang" class="form-horizontal">
                                                <input type="hidden" name="txt-final-attendance-id" value="{{ $event->id }}">
                                                <input type="hidden" name="txt-tarikh" class="txt-tarikh">
                                                <input type="hidden" name="txt-medan-kesalahan" value="{{ $Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG }}">
                                                @if (!$pagi && sizeof($kesalahan) == 2)
                                                    <div class="col-sm-12">
                                                        <input type="checkbox" name="chk-sama-pagi" id="chk-sama-pagi" value="SAMA">
                                                        Justifikasi sama untuk kedua-dua kesalahan
                                                    </div>
                                                @endif
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" name="txt-justifikasi" id="txt-justifikasi-petang" cols="30" rows="10"></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button id="btn-justifikasi-petang" class="btn btn-justifikasi btn-primary btn-flat" type="submit"><i class="fa fa-send "></i> Simpan Justifikasi {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckOut($event->kesalahan)] }} </button>
                                                </div>
                                            </form>
                                        @else
                                            @if ($Utility::kesalahanCheckOut($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                                <div>Kesalahan : {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckOut($event->kesalahan)] }}</div>
                                                <div class="show-read-more">Alasan : {{ optional($petang)->keterangan }}</div>
                                                <div>Status : {{ optional($petang)->flag_kelulusan }}</div>
                                                
                                                <!--
                                                <br> 
                                                                                                
                                                <button type="button" class="btn btn-danger pull-left btn-hapus-acara" data-id="{{ optional($petang)->id }}" ><span class="glyphicon glyphicon-trash"></span> Hapus</button>
                                                -->
                                                
                                            @endif
                                        @endif
                                    </td>
                                    <?php }else{ ?>                                    
                                    <td style="width: 50%;"></td>
                                    <?php } ?>
                                </tr>
                            @endif
                        </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            @endif
        @endif
        
        <!--
         @if ($event instanceof App\Acara)
        
        	
            
         @endif
        -->
        
      
  

        @if ($event instanceof App\Acara)
        
        	<?php
			/*
			$tarikh_mula_time = $event->tarikh_mula_time;
			$tarikh_tamat_time = $event->tarikh_tamat_time;
			
			$masa_balik_9jam = $tarikh_mula_time + (60*60*9);
			
			if(($tarikh_mula_time <= '090000') && ($tarikh_tamat_time >= '090000')){
				$check_punchin++;
			}
			if(($tarikh_mula_time <= $masa_balik_9jam) && ($tarikh_tamat_time >= $masa_balik_9jam)){
				$check_punchout++;
			}
			*/
			
			if($status_permohonan == 'BATAL'){
				
			}else{
			
			
			?> 
            
            
        	
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                <h3 class="box-title">{{ strtoupper($event->descKategori()) }} : {{ $event->title }}</h3>

                <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                    
                    @if (($event->kategori == 'T') || ($event->kategori == 'C'))
            
            			<table class="table table-hover">
                            {{-- <tr>
                                <td>JENIS ACARA</td>
                                <td>{{ strtoupper($event->descKategori()) }}</td>
                            </tr> --}}
                            <tr>
                                <td>TARIKH & MASA MULA</td>
                                <td>{{ date("d-m-Y", strtotime($event->start)).' | '.date("h:i:s A", strtotime($event->start)) }}</td>
                            </tr>
                            <tr>
                                <td>TARIKH & MASA TAMAT</td>
                                <td>{{ date("d-m-Y", strtotime($event->end)).' | '.date("h:i:s A", strtotime($event->end)) }}</td>
                            </tr>
                            <tr>
                                <td>KETERANGAN</td>
                                <td>{{ $event->keterangan }}</td>
                            </tr>
                            <tr>
                                <td>STATUS</td>
                                <td>{{ $event->flag_kelulusan }}</td>
                            </tr>
                        </table>
            
                    @endif
                    
                    @if ($event->kategori == 'J')
            
            			<table class="table table-hover">
                            {{-- <tr>
                                <td>JENIS ACARA</td>
                                <td>{{ strtoupper($event->descKategori()) }}</td>
                            </tr> --}}
                            <tr>
                                <td>KATEGORI</td>
                                <td>{{ $event->medan_kesalahan }}</td>
                            </tr>
                            <tr>
                                <td>TARIKH</td>
                                <td>{{ date("d-m-Y", strtotime($event->start)) }}</td>
                            </tr>
                            <tr>
                                <td>KETERANGAN</td>
                                <td>{{ $event->keterangan }}</td>
                            </tr>
                            <tr>
                                <td>STATUS</td>
                                <td>{{ $event->flag_kelulusan }}</td>
                            </tr>
                        </table>                        
                    
                    @endif  
                    
                    	
                        <?php
						/**/
						
						
						//if($check_punchin > 0){
						
						?> 
                        
                        <!-- 
                        <table class="table table-hover">
                            <tr>
                                <td>PI</td>
                                <td><?php echo $check_punchin; ?></td>
                            </tr>
                            <tr>
                                <td>PO</td>
                                <td><?php echo $check_punchout; ?></td>
                            </tr>
                            <tr>
                                <td>TIME IN OUT</td>
                                <td><?php //echo $tarikh_mula_time.' '.$tarikh_tamat_time; ?></td>
                            </tr>
                        </table> 
                            -->     
                    
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            
            <?php
			}
			?>
                        
            
        @endif
        
        <?php
            
		//echo $check_punchin;
		//echo $check_punchout;
		//}
		?>     
        
    @endforeach
</div>




