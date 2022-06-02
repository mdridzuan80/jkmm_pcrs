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
    $list_acara3 = $collection['list_acara2'];
@endphp

@section('content')
    <section class="content-header">
        <h1>
        <i class="fa fa-commenting"></i></i> Senarai Acara
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
                                
                                <form name="kelulusan_justifikasi" method="POST" action="{{ route('post.kelulusan.list_acara') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <table id="datatable_1" cellspacing="0" width="100%" class="table table-striped table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <td width="1"><b>Kategori</b></td>
                                                <td>
                                                    <select class="form-control" name="kategori_acara">
                                                        <option value="0" {{ session('session_ka1')=='0'?'selected':''}} >[SEMUA]</option>
                                                        <option value="J" {{ session('session_ka1')=='J'?'selected':''}} >Justifikasi</option>
                                                        <option value="T" {{ session('session_ka1')=='T'?'selected':''}} >Timeslip</option>
                                                        <option value="C" {{ session('session_ka1')=='C'?'selected':''}} >Catatan</option>
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
					$kira = 0;
					$content = 'test'
                ?>
                
                <table class="table table-hover table-striped" style="font-size: 14px !important;">
                  <tbody>
                  
                  			<tr>
                            	<th width="5%" align="center">#</th>
                                <th width="15%">Nama</th>
                                <th width="10%" align="center">Tarikh & Masa</th>
                                <th width="8%">Kategori</th>
                                <th width="8%">Kesalahan</th>
                                <th width="12%">Perkara</th>
                                <th>Keterangan</th>
                                <th width="8%">Status</th>
                                <th align="center">Operasi</th>
                            </tr>
                            
                             @foreach ($list_acara3 as $acara_jtc)
                              
                              @php
                                if($acara_jtc->kategori == 'J'){
                                	$acara_jtc_kategori = 'Justifikasi';
                                }
                                if($acara_jtc->kategori == 'T'){
                                	$acara_jtc_kategori = 'Timeslip';
                                }
                                if($acara_jtc->kategori == 'C'){
                                	$acara_jtc_kategori = 'Catatan';
                                }
                            @endphp
                            
                            @php
                            	if($acara_jtc->tarikh_mula->format('d-M-Y') == $acara_jtc->tarikh_tamat->format('d-M-Y')){
                                	$acara_jtc_tarikh_finale = $acara_jtc->tarikh_mula->format('d.m.Y').' ('.$acara_jtc->tarikh_mula->format('H:i').' - '.$acara_jtc->tarikh_tamat->format('H:i').')';
                                }
                                
                                if($acara_jtc->tarikh_mula->format('d-M-Y') != $acara_jtc->tarikh_tamat->format('d-M-Y')){
                                	
                                    $acara_jtc_tarikh_finale = $acara_jtc->tarikh_mula->format('d.m.Y').' - '.$acara_jtc->tarikh_tamat->format('d.m.Y').' ('.$acara_jtc->tarikh_mula->format('H:i').' - '.$acara_jtc->tarikh_tamat->format('H:i').')';
                                }
                                
                                /*
                                if($acara_jtc->medan_kesalahan == 'PAGI'){
                                	$acara_jtc_waktu = ' (Pg)'; 
                                    
                                    if(strpos($acara_jtc->acara_finalAttendance->kesalahan, 'NONEIN') !== false){
                                    	$jenis_kesalahan = 'Tidak Punch-In';                                    
                                    }
                                    if(strpos($acara_jtc->acara_finalAttendance->kesalahan, 'LEWAT') !== false){
                                    	$jenis_kesalahan = 'Hadir Lewat';                                    
                                    }
                                                                   
                                }
                                elseif($acara_jtc->medan_kesalahan == 'PETANG'){
                                	$acara_jtc_waktu =  ' (Ptg)'; 
                                    
                                    if(strpos($acara_jtc->acara_finalAttendance->kesalahan, 'NONEOUT') !== false){
                                    	$jenis_kesalahan = 'Tidak Punch-Out';                                    
                                    }
                                    if(strpos($acara_jtc->acara_finalAttendance->kesalahan, 'AWAL') !== false){
                                    	$jenis_kesalahan = 'Pulang Awal';                                    
                                    }                               
                                }else{
                                	$acara_jtc_waktu = '';
                                    $jenis_kesalahan = '-';                                 
                                }
                                */
                                
                                	$acara_jtc_waktu = '-';
                                    $jenis_kesalahan = '-';
                                    $namaa = '-'
                                
                            @endphp
                            
                            
                            <tr>
                            	<td><?php echo $nombor++; ?>.</td>
                                <td>{{ $acara_jtc->namaa }}</td>
                                <td>{{ $acara_jtc_tarikh_finale }}</td>
                                <td>{{ $acara_jtc_kategori.$acara_jtc_waktu }}</td>
                                <td>{{ $jenis_kesalahan }}</td>                                
                                <td>{{ $acara_jtc->perkara }}</td>
                                <td>{{ $acara_jtc->keterangan }}</td>
                                <td>{{ $acara_jtc->flag_kelulusan }}</td>
                                <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs bg-olive btn-lulus" data-id="{{ $acara_jtc->id }}" ><i class="fa fa-check-circle"></i> Lulus</button>
                                    <button type="button" class="btn btn-xs btn-danger btn-tolak" data-id="{{ $acara_jtc->id }}" > <i class="fa fa-times-circle"></i> Tolak</button>
                                  </div>                                
                                </td>
                            </tr>
                            
							  
                                
                            @endforeach
                            
                 
                       
                   
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