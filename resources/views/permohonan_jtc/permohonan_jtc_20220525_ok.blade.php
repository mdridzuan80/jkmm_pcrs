@inject('Utility', 'App\Utility')
@inject('Acara', 'App\Acara')

@extends('layouts.master')

<script type="text/javascript"> 
/*
$(document).ready(function() {
    $('#datatable_1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
*/
</script>

<script type="text/javascript">
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
</script> 


<script type="text/javascript"> 

$(document).ready(function() {
    $('#datatable_22').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );



$(document).ready( function () {
    $('#myTable').DataTable();
} );


</script>

<script type="text/javascript">
$(document).ready(function () {
$('#datatable_144').DataTable({
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
</script> 



<!--script datable !-->




@section('content')


    <section class="content-header">
        <h1>
        <i class="fa fa-list"></i></i> Senarai Permohonan
        <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Senarai Permohonan</li>
        </ol>
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
                    <div class="box-body table-responsive" style="overflow-x:hidden;">
                                
                                <!--<form target="_blank" name="kelulusan_justifikasi" method="POST" action="{{ route('permohonan_jtc.permohonan_jtc') }}" enctype="multipart/form-data">-->
                                <form target="_blank" id="form-permohonan-jtc" name="jtc" method="POST" action="{{ route('pdf.permohonan_jtc') }}">
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
                                    
                                    
                                    <table class="table table-bordered" style="font-size:14px !important;">
                                        <tbody>
                                            <tr>
                                                <td width="1"><b>Kategori</b></td>
                                                <td>
                                                    <select class="form-control" id="kategori_acara" name="kategori_acara">
                                                        <option value="0" <?php if(request()->kategori_acara == '0'){ echo 'selected'; } ?> >[SEMUA]</option>[SEMUA]</option>
                                                        <option value="J" <?php if(request()->kategori_acara == 'J'){ echo 'selected'; } ?> >Justifikasi</option>
                                                        <option value="T" <?php if(request()->kategori_acara == 'T'){ echo 'selected'; } ?> >Timeslip</option>
                                                        <option value="C" <?php if(request()->kategori_acara == 'C'){ echo 'selected'; } ?> >Catatan</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="1"><b>Tarikh&nbsp;Mula</b></td>
                                                <td>
                                                    <!-- <input type="text" class="form-control" name="txtTarikhMula" id="txtTarikhMula" autocomplete="off" value="{{ now()->subDay()->format('Y-m-d') }}" required> -->
                                                    
                                                   
                                                    
                                                    <input type="text" class="form-control" name="txtTarikhMula" id="txtTarikhMula" autocomplete="off" value="<?php echo $tarikh_awal_bulan_semasa; ?>" placeholder="Sila pilih..." required>
                                                    
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="1"><b>Tarikh&nbsp;Akhir</b></td>
                                                <td>
                                                    
                                                   
                                                    
                                                    <input type="text" class="form-control" name="txtTarikhAkhir" id="txtTarikhAkhir" autocomplete="off" value="<?php echo $tarikh_semasa; ?>" placeholder="Sila pilih..." required>
                                                    
                                                    
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button type="button" id="btn_hantar_jtc" class="btn btn-primary btn-flat" name="btn_hantar_jtc">Papar</button>
                                            		<button type="submit" id="cmdJanaLaporanTimeslip_pdf" class="btn btn-success btn-flat" name="btn_pdf">Jana PDF</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>                         
                       </form>
 <!--
                        
                        <div id="lala789">

                        </div>
                        
                        <div id="rst-lpt-kehadiran789">
                            &nbsp;
                        </div>
                        -->
                        
   
                        
                        
                    <div class="row">
                        <div id="report_view2" class="col-md-12"></div>
                 	</div> 
                                
                                
                            </div>
                    </div>
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
  
  
  
  			$('#btn_hantar_jtc').on('click', function(e) {	
		// $('#form-laporanrekodkehadiran1212').on('submit', function(e) {
			e.preventDefault();
		
			var kategori_acara = $("#kategori_acara").val();
			var txtTarikhMula = $("#txtTarikhMula").val();
			var txtTarikhAkhir = $("#txtTarikhAkhir").val();
		
					console.log(kategori_acara);
					console.log(txtTarikhMula);
					console.log(txtTarikhAkhir);
					
					$.ajax({
						url: base_url+'permohonan_jtc',
						method: 'POST',
				"headers": {
					"Accept": "application/json"
				},
			data: {
				'kategori_acara': kategori_acara,
				'txtTarikhMula': txtTarikhMula,
				'txtTarikhAkhir': txtTarikhAkhir,
			},
				success: function(response){
					$('#report_view2').html(response);
				}
			});
		});	
  
  
  
  
</script>
@endsection