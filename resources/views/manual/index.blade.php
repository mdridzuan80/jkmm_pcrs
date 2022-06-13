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
        <i class="fa fa-book"></i></i> Manual Pengguna
        <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Manual Pengguna</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Manual Pengguna bagi PCRS</h3>

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
                                
                                
                                    
                                    
                                    <table class="table table-bordered biasa" style="font-size:14px !important;">
                                        
                                        <thead>
                                            <tr>
                                                <th align="center" width="10%" style="text-align:center !important;"><b>#</b></th>
                                                <th><b>PERKARA</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr>
                                                <td align="center">1.</td>
                                                <td width="1"><a href="{{ asset('images/manual/MANUAL_PCRS_-_PENGGUNA_v2.0.pdf') }}" target="_blank"><b>Manual Pengguna</b></a></td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.</td>
<<<<<<< HEAD
                                                <td width="1"><a href="{{ asset('images/manual/MANUAL_PCRS_-_PENTADBIR_BAHAGIAN_v2.0_latest.pdf') }}" target="_blank"><b>Manual Pentadbir Bahagian</b></a></td>
=======
                                                <td width="1"><a href="{{ asset('images/manual/MANUAL_PCRS_-_PENTADBIR_BAHAGIAN_v2.0.pdf') }}" target="_blank"><b>Manual Pentadbir Bahagian</b></a></td>
>>>>>>> b00d96210a3b1cb9f410bd83eb9c990ef31cf4fd
                                            </tr>
                                            <tr>
                                                <td align="center">3.</td>
                                                <td width="1"><a href="{{ asset('images/manual/MANUAL_PCRS_-_KETUA_BAHAGIAN_v2.0.pdf') }}" target="_blank"><b>Manual Ketua Bahagian</b></a></td>
                                            </tr>
                                            <tr>
                                                <td align="center">4.</td>
                                                <td width="1"><a href="{{ asset('images/SESI TOT PCRS2.0.pdf') }}" target="_blank"><b>Slide TOT PCRS</b></a></td>
                                            </tr>
                                        </tbody>
                                    </table>                         
                       
                                
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