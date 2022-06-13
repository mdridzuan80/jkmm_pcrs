@inject('Utility', 'App\Utility')
@inject('Acara', 'App\Acara')

@extends('layouts.master')
@php
    $permohonan = $collection['permohonan'];
@endphp



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














@section('content')
    <section class="content-header">
        <h1>
        <i class="fa fa-list"></i></i> Senarai Permohonan
        </h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Permohonan Justifikasi/ Timeslip/ Catatan</h3>

              {{-- <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div> --}}
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            
            
            
            
            
            
            <!-- Main content -->
                <div class="row">
                    <div class="col-md-12">
                            <div class="box-body table-responsive">
                                
                                <form name="kelulusan_justifikasi" method="POST" action="{{ route('permohonan_jtc.permohonan_jtc') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    
                                    
                                    <?php
									
									$tarikh_semasa = date("Y-m-d");
									$bulan_semasa = date("m");
									$tahun_semasa = date("Y");
									
									$tarikh_awal_bulan_semasa = $tahun_semasa.'-'.$bulan_semasa.'-01';
									
			/*
									if ($permohonan->count()){}else{
									
									
									
									
									
									session('session_ta_ljtc') = $tarikh_semasa;
									
									}
									*/
									
									?>
                                    
                                    
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="1"><b>Kategori</b></td>
                                                <td>
                                                    <select class="form-control" name="kategori_acara">
                                                        <option value="0" {{ session('session_ka_ljtc')=='0'?'selected':''}} >[SEMUA]</option>
                                                        <option value="J" {{ session('session_ka_ljtc')=='J'?'selected':''}} >Justifikasi</option>
                                                        <option value="T" {{ session('session_ka_ljtc')=='T'?'selected':''}} >Timeslip</option>
                                                        <option value="C" {{ session('session_ka_ljtc')=='C'?'selected':''}} >Catatan</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="1"><b>Tarikh&nbsp;Mula</b></td>
                                                <td>
                                                    <!-- <input type="text" class="form-control" name="txtTarikhMula" id="txtTarikhMula" autocomplete="off" value="{{ now()->subDay()->format('Y-m-d') }}" required> -->
                                                    
                                                    <?php
													if (isset($_POST['btn_hantar_jtc'])) {													
													?>													
														
                                                    
                                                    <input type="text" class="form-control" name="txtTarikhMula" id="txtTarikhMula" autocomplete="off" value="<?php echo $_POST['txtTarikhMula']; ?>" placeholder="Sila pilih..." required>
                                                    
                                                    <?php }else{ ?>
                                                    
                                                    <input type="text" class="form-control" name="txtTarikhMula" id="txtTarikhMula" autocomplete="off" value="<?php echo $tarikh_awal_bulan_semasa; ?>" placeholder="Sila pilih..." required>
                                                    
                                                    <?php } ?>
                                                    
                                                    
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="1"><b>Tarikh&nbsp;Akhir</b></td>
                                                <td>
                                                    
                                                    @php
													if (isset($_POST['btn_hantar_jtc'])) {													
													@endphp													
														
                                                    
                                                    <input type="text" class="form-control" name="txtTarikhAkhir" id="txtTarikhAkhir" autocomplete="off" value="<?php echo $_POST['txtTarikhAkhir']; ?>" placeholder="Sila pilih..." required>
                                                    
                                                    @php }else{ @endphp
                                                    
                                                    <input type="text" class="form-control" name="txtTarikhAkhir" id="txtTarikhAkhir" autocomplete="off" value="<?php echo $tarikh_semasa; ?>" placeholder="Sila pilih..." required>
                                                    
                                                    @php } @endphp
                                                    
                                                    
                                                    
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button type="submit" id="btn-export-PDF" name="btn_hantar_jtc" class="btn btn-primary btn-flat">Papar</button>
                                            		
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                                
                            </div>
                    </div>
                </div>
            
            
            <div class="row">
                    <div class="col-md-12">
            
            <div class="box-body">
              <div class="table-responsive mailbox-messages">
              
              <?php
                	//if (isset($_POST['btn_hantar_kelulusan'])) {					
						//echo $_POST['kategori_acara'];
					//}
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
                    @if ($permohonan->count())
                        @foreach ($permohonan as $justifikasi)
                            
                            @php
                                if($justifikasi->kategori == 'J'){
                                	$justifikasi_kategori = 'Justifikasi';
                                }
                                if($justifikasi->kategori == 'T'){
                                	$justifikasi_kategori = 'Timeslip';
                                }
                                if($justifikasi->kategori == 'C'){
                                	$justifikasi_kategori = 'Catatan';
                                }
                            @endphp
                            
                            @php
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
				

                            	
				
                            @endphp
                            
                            @php
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
                            @endphp
                            
                            
                            <?php
                            
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
                                        <button type="button" class="btn btn-xs btn-danger btn-batal" disabled="disabled" ><i class="fa fa-check-circle"></i> Batal</button>
                                      </div>
                                      
								  <?php
                                  }else{
								  ?>
                                  
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-danger btn-batal" data-id="{{ $justifikasi->id }}" ><i class="fa fa-check-circle"></i> Batal</button>
                                  </div> 
                                      
								  <?php
                                  }
								  ?>                              
                                </td>
                            </tr>
                            
                        @endforeach
                    @else
                        <tr align="center"><td colspan="9">Tiada permohonan</td></tr>
                    @endif
                  </tbody>
                </table>
                
                <?php
                	//if (isset($_POST['btn_hantar_kelulusan'])) {					
						//echo $_POST['kategori_acara'];
					//}
                ?>
                
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
          </div>
    </section>
@endsection

@section('scripts')
<script>
  
 	
	$('#txtTarikhMula').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight: true,
		autoclose: true,
		todayBtn: true,
		orientation: 'bottom',
		zIndexOffset: 10
	})
	
	$('#txtTarikhAkhir').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight: true,
		autoclose: true,
		todayBtn: true,
		orientation: 'bottom',
		zIndexOffset: 10
	})
  
  
  $(function() {
    $(".btn-batal").on('click', function(e){
      e.preventDefault();
      
      permohonan_jtc(this,'{{ $Acara::STATUS_PERMOHONAN_BATAL }}')
    });

    function permohonan_jtc(el,status) {
      var id = $(el).data('id');

      swal({
          title: 'Amaran!',
          text: 'Anda pasti untuk membatalkan permohonan ini?',
          type: 'warning',
          cancelButtonText: 'Tidak',
          showCancelButton: true,
          confirmButtonText: 'Ya!',
          showLoaderOnConfirm: true,
          allowOutsideClick: () => !swal.isLoading(),
          preConfirm: (email) => {
              return new Promise((resolve,reject) => {
                    $.ajax({
                      method: 'POST',
                      data: {'_method':'PUT', status: status},
                      url: base_url+'rpc/permohonan_jtc/'+id,
                      success: function(data, extStatus, jqXHR) {
                          resolve({value: true});
                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                          reject(textStatus);
                      },
                      statusCode: login()
                  });
              })
          }
      }).then((result) => {
          if (result.value) {
              swal({
                  title: 'Berjaya!',
                  text: 'Permohonan telah dibatalkan',
                  type: 'success'
              }).then(() => $(el).parent().parent().parent().hide());
          }
      }).catch(function (error) {
          swal({
              title: 'Ralat!',
              text: 'Permohonan tidak berjaya dibatalkan!. Sila berhubung dengan Pentadbir sistem',
              type: 'error'
          });
      });
    }
  });
  
  
  
  
  
  
  
</script>
@endsection