@inject('Utility', 'App\Utility')
@inject('Justifikasi', 'App\Justifikasi')

@extends('layouts.master')
@php
    $permohonan = $collection['permohonan'];
@endphp
@section('content')
    <section class="content-header">
        <h1>
        <i class="fa fa-commenting"></i></i> Kelulusan Justifikasi
        <small>Menguruskan permohonan justifikasi anggota</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Kelulusan Justifikasi</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Permohonan Justifikasi</h3>

              {{-- <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div> --}}
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    @if ($permohonan->count())
                        @foreach ($permohonan as $justifikasi)
                            <tr>
                                <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                <td class="mailbox-name">{{ $justifikasi->finalAttendance->anggota->nama }}</td>
                                <td class="mailbox-subject">
                                  <b>[{{ $justifikasi->tarikh->format('d-M-Y') }} - {{ $justifikasi->medan_kesalahan }}, {{ $Utility::kesalahan($justifikasi->medan_kesalahan, $justifikasi->finalAttendance->kesalahan) }}]</b> - <span>{{$justifikasi->keterangan}}</span>
                                </td>
                                <td class="mailbox-date">{{ $justifikasi->created_at->diffForHumans() }}</td>
                                <td class="mailbox-date">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-xs bg-olive btn-lulus" data-id="{{ $justifikasi->id }}" ><i class="fa fa-check-circle"></i> Lulus</button>
                                    <button type="button" class="btn btn-xs btn-danger btn-tolak" data-id="{{ $justifikasi->id }}" > <i class="fa fa-times-circle"></i> Tolak</button>
                                  </div>̦
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td>Tiada permohonan</td></tr>
                    @endif
                  </tbody>
                </table>
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
    $(".btn-lulus").on('click', function(e){
      e.preventDefault();
      
      kelulusan(this,'{{ $Justifikasi::FLAG_KELULUSAN_LULUS }}')
    });

    $(".btn-tolak").on('click', function(e){
      e.preventDefault();
      
      kelulusan(this,'{{ $Justifikasi::FLAG_KELULUSAN_TOLAK }}')
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