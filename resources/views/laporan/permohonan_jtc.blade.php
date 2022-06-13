@inject('Utility', 'App\Utility')
@inject('Acara', 'App\Acara')

@extends('layouts.master')
@php
    $permohonan = $collection['permohonan'];
@endphp
@section('content')
    <section class="content-header">
        <h1>
        <i class="fa fa-commenting"></i></i> Laporan Permohonan
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
                                
                                <form name="kelulusan_justifikasi" method="POST" action="{{ route('laporan.permohonan_jtc') }}" enctype="multipart/form-data">
                                    @csrf
                                    
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
                ?>
                
                <?php $nombor = 1; ?>
                
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
                                <th>Status</th>
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
				//dd($justifikasi);
				

                            	
				
                            @endphp
                            
                           
                            
                            
                            <tr>
                            	<td><?php echo $nombor++; ?>.</td>
                                <td>{{ $justifikasi->id }}</td>
                                <td>{{ $justifikasi->tarikh_mula->format('d-M-Y') }}</td>
                                <td>{{ $justifikasi_kategori }}</td>
                                <td></td>                                
                                <td>{{ $justifikasi->perkara }}</td>
                                <td>{{ $justifikasi->keterangan }}</td>
                                <td>{{ $justifikasi->flag_kelulusan }}</td>
                                <td>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-danger btn-batal" data-id="{{ $justifikasi->id }}" ><i class="fa fa-check-circle"></i> Batal</button>
                                  </div>̦                                
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