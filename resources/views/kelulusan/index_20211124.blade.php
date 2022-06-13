@inject('Utility', 'App\Utility')
@inject('Acara', 'App\Acara')

@extends('layouts.master')

<script type="text/javascript"> 

$(document).ready(function() {
    $('#datatable_1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

</script>


@php
    $permohonan = $collection['permohonan'];
@endphp
@section('content')
    <section class="content-header">
        <h1>
        <i class="fa fa-commenting"></i></i> Kelulusan Permohonan
        <small>Menguruskan permohonan justifikasi, timeslip atau catatan anggota</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Kelulusan Permohonan</li>
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
                            <div class="box-body table-responsive">
                                
                                <form name="kelulusan_justifikasi" method="POST" action="{{ route('post.kelulusan') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <table id="datatable_1" cellspacing="0" width="100%" class="table table-striped table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <td width="1"><b>Kategori</b></td>
                                                <td>
                                                    <select class="form-control" name="kategori_acara">
                                                        <option value="0" {{ session('session_ka')=='0'?'selected':''}} >[SEMUA]</option>
                                                        <option value="J" {{ session('session_ka')=='J'?'selected':''}} >Justifikasi</option>
                                                        <option value="T" {{ session('session_ka')=='T'?'selected':''}} >Timeslip</option>
                                                        <option value="C" {{ session('session_ka')=='C'?'selected':''}} >Catatan</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button type="submit" id="btn-export-PDF" name="btn_hantar_kelulusan" class="btn btn-primary btn-flat">Hantar</button>
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
					
					$nombor = 1;
                ?>
                
                <table class="table table-hover table-striped">
                  <tbody>
                  
                  			<tr>
                            	<th>#</th>
                                <th>Nama</th>
                                <th>Tarikh</th>
                                <th>Kategori</th>
                                <th>Kesalahan</th>
                                <th>Perkara</th>
                                <th>Keterangan</th>
                                <th>Operasi</th>
                            </tr>
                            
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
                            
                            
                            <tr>
                            	<td><?php echo $nombor++; ?>.</td>
                                <td>{{ $justifikasi->acara_userinfo->nama }}</td>
                                <td>{{ $justifikasi->tarikh_mula->format('d-M-Y') }}</td>
                                <td>{{ $justifikasi_kategori.$justifikasi_waktu }}</td>
                                <td>{{ $jenis_kesalahan }}</td>                                
                                <td>{{ $justifikasi->perkara }}</td>
                                <td>{{ $justifikasi->keterangan }}</td>
                                <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs bg-olive btn-lulus" data-id="{{ $justifikasi->id }}" ><i class="fa fa-check-circle"></i> Lulus</button>
                                    <button type="button" class="btn btn-xs btn-danger btn-tolak" data-id="{{ $justifikasi->id }}" > <i class="fa fa-times-circle"></i> Tolak</button>
                                  </div>                                
                                </td>
                            </tr>
                            
                        @endforeach
                    @else
                        <tr align="center"><td colspan="7">Tiada permohonan</td></tr>
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
	
	
	$( "#txtTarikhMula2" ).datepicker({
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  dateFormat: 'yy-mm-dd',
	  onClose: function( selectedDate ) {
		$( "#txtTarikhAkhir2" ).datepicker( "option", "minDate", selectedDate );
	  }
	});
	
	$( "#txtTarikhAkhir2" ).datepicker({
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  dateFormat: 'yy-mm-dd',
	  onClose: function( selectedDate ) {
		$( "#txtTarikhMula2" ).datepicker( "option", "maxDate", selectedDate );
	  }
	});
	
  
  $(function() {
    $(".btn-lulus").on('click', function(e){
      e.preventDefault();
      
      kelulusan(this,'{{ $Acara::STATUS_PERMOHONAN_LULUS }}')
    });

    $(".btn-tolak").on('click', function(e){
      e.preventDefault();
      
      kelulusan(this,'{{ $Acara::STATUS_PERMOHONAN_TOLAK }}')
    });

    function kelulusan(el,status) {
      var id = $(el).data('id');

      swal({
          title: 'Amaran!',
          text: 'Anda pasti untuk melaksanakan tindakan ini?',
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
                      url: base_url+'rpc/justifikasi/'+id,
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
                  text: 'Maklumat telah dikemaskini',
                  type: 'success'
              }).then(() => $(el).parent().parent().parent().hide());
          }
      }).catch(function (error) {
          swal({
              title: 'Ralat!',
              text: 'Pengemaskinian tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
              type: 'error'
          });
      });
    }
  });
</script>
@endsection