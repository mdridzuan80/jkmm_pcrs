<script type="text/javascript">
$(document).ready(function () {
$('#datatable_1').DataTable({
"scrollX": false,
 //"searching": false,
 dom: 'Bfrtip',
	 lengthMenu: [
		[ 10, 25, 50, -1 ],
		[ '10 rows', '25 rows', '50 rows', 'Show all' ]
	], 

	buttons: [

		'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'

	] 
 
});
$('.dataTables_length').addClass('bs-select');
});


$(document).ready(function () {
$('#datatable_2').DataTable({
"scrollX": false,
 //"searching": false,
 dom: 'Bfrtip',
	 lengthMenu: [
		[ 10, 25, 50, -1 ],
		[ '10 rows', '25 rows', '50 rows', 'Show all' ]
	], 

	buttons: [

		'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'

	] 
 
});
$('.dataTables_length').addClass('bs-select');
});




$(document).ready(function() {
    $('#datatable_12').DataTable( {
        dom: 'Bfrtip',
	 lengthMenu: [
		[ 10, 25, 50, -1 ],
		[ '10 rows', '25 rows', '50 rows', 'Show all' ]
	], 
	
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

</script> 


<div class="row">
    <div class="col-md-12">
            
            <div class="box-body">
              <div class="table-responsive mailbox-messages">
              
              <?php
					
					//echo $kategori_acara.' | '.$txtTarikhMula.' | '.$txtTarikhAkhir;
					
                ?>
                
                <?php $nombor = 1; ?>
                
                <table id="datatable_1" class="table table-hover table-striped" style="font-size: 14px !important;">
                  <thead>
                  
                  			<tr>
                            	<th width="5%" style="text-align:center;">#</th>
                                <th width="15%">Nama</th>
                                <th width="10%" style="text-align:center;">Tarikh & Masa</th>
                                <th width="8%" style="text-align:center;">Kategori</th>
                                <th width="8%" style="text-align:center;">Kesalahan<br />Justifikasi</th>
                                <th width="12%">Perkara</th>
                                <th>Keterangan</th>
                                <th width="8%" style="text-align:center;">Status</th>
                                <th width="8%" style="text-align:center;">Operasi</th>
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
                            
                            <tr>
                            	<td><?php echo $nombor++; ?>.</td>
                                <td>{{ $justifikasi->acara_userinfo->nama }}</td>
                                <td align="center"><?php echo $justifikasi_tarikh_finale; ?></td>
                                <td align="center">{{ $justifikasi_kategori.$justifikasi_waktu }}</td>                                
                                <td align="center">{{ $jenis_kesalahan }}</td>                                                                
                                <td>{{ $justifikasi->perkara }}</td>
                                <td>{{ $justifikasi->keterangan }}</td>
                                <td align="center" style="color:<?php echo $color_status; ?>;">{{ $status_permohonan }}</td>
                                <td align="center">
                                  
                                  <?php
								  if($justifikasi->flag_kelulusan == 'BATAL'){
								  ?>
									  
                                      <div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-danger btn-batal2" disabled="disabled" ><i class="fa fa-check-circle"></i> Batal</button>
                                      </div>
                                      
								  <?php
                                  }else{
								  ?>
                                  
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-danger btn-batal2" data-id="{{ $justifikasi->id }}" ><i class="fa fa-check-circle"></i> Batal</button>
                                  </div> 
                                      
								  <?php
                                  }
								  ?>                              
                                </td>
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
                
                
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            
    </div>
</div>
