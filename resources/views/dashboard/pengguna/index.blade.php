@extends('layouts.master')
@inject('Justifikasi', 'App\Repositories\Justifikasi')
@inject('Acara', 'App\Acara')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-dashboard"></i></i> Dashboard
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <!--
                            @if (Auth::user()->email != env('PCRS_DEFAULT_USER_ADMIN', 'admin@internal') && Auth::user()->xtraAnggota->baseDepartment->isActiveBdr())
    <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-fw fa-calendar"></i> BDR Check-In/Out</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="card card-widget widget-user">
                                            <?php //Add the bg color to the header using any of the bg-* classes
                                            ?>
                                            <div class="widget-user-header bg-info">
                                                <h3 class="widget-user-username">{{ Auth::user()->xtraAnggota ? Auth::user()->xtraAnggota->nama : Auth::user()->name }}</h3>
                                                <h5 class="widget-user-desc">
                    @if (Auth::user()->email === env('PCRS_DEFAULT_USER_ADMIN', 'admin@internal'))
    <small>Sistem Administrator</small>
@else
    <small>{{ ucfirst(Auth::user()->xtraAnggota->jawatan) }}</small>
    @endif
                                                </h5>
                                            </div>
                                            <div class="card-footer" id="app-bdr-check-inout">
                                                <div class="row">
                                                    <div class="col-sm-3 border-right">
                                                        <div class="description-block">
                                                            <button type="button" class="btn btn-block btn-success btn-lg" :disabled="isCheckIn" @click="checkingIn">Check-In</button>
                                                        </div>
                                                        <?php // /.description-block
                                                        ?>
                                                    </div>
                                                    <?php // /.col
                                                    ?>
                                                    <div class="col-sm-3 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">@{{ checkInDate }}</h5>
                                                            <span class="description-text">@{{ checkInTime }}</span>
                                                        </div>
                                                        <?php // /.description-block
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-3 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">@{{ checkOutDate }}</h5>
                                                            <span class="description-text">@{{ checkOutTime }}</span>
                                                        </div>
                                                        <?php // /.description-block
                                                        ?>
                                                    </div>
                                                    <?php // /.col
                                                    ?>
                                                    <div class="col-sm-3">
                                                        <div class="description-block">
                                                            <button type="button" class="btn btn-block btn-danger btn-lg" :disabled="isCheckOut" @click="checkingOut">Check-Out</button>
                                                        </div>
                                                        <?php // /.description-block
                                                        ?>
                                                    </div>
                                                    <?php // /.col
                                                    ?>
                                                </div>
                                                <?php // /.row
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    @endif
                            -->


            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fw fa-calendar"></i> Kalendar</h3>
                        <div class="box-tools pull-right">
                            <!-- Buttons, labels, and many other things can be placed here! -->
                            <!-- Here is a label for example -->
                            <span id='petunjuk'><i class="fa fa-fw fa-info"></i></span>
                        </div><!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                        <div id="calendar"></div>
                    </div>
                    <div class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default-timeslip" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: steelblue; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"><i class="fa fa-fw fa-calendar-plus-o"></i> MOHON TIMESLIP (URUSAN
                            PERIBADI)</h4>
                    </div>
                    <div class="modal-body">
                        <h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-default-catatan" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: steelblue; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"><i class="fa fa-fw fa-calendar-plus-o"></i> MOHON CATATAN (URUSAN RASMI)
                        </h4>
                    </div>
                    <div class="modal-body">
                        <h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-acara-anggota" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: steelblue; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(function() {

            var options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            };

            function success(pos) {
                var crd = pos.coords;

                console.log('Your current position is:');
                console.log(`Latitude : ${crd.latitude}`);
                console.log(`Longitude: ${crd.longitude}`);
                console.log(`More or less ${crd.accuracy} meters.`);
            }

            function error(err) {
                console.warn(`ERROR(${err.code}): ${err.message}`);
            }

            navigator.geolocation.getCurrentPosition(success, error, options);



            var acara = {
                jenisAcara: '',
                perkara: '',
                masaMula: '',
                masaTamat: '',
                keterangan: '',
                hours: 0,
            };

            var dateClick = '';

            var acaraUrlProp = {
                schema: '',
                schema_id: ''
            };

            var frmJustifikasi = {
                finalAttendance: '',
                tarikh: '',
                sama: '{{ $Justifikasi::FLAG_JUSTIKASI_TIDAK_SAMA }}',
                medanKesalahan: '',
                alasan: ''
            };

            var gEvents = {};

            var cal = $('#calendar').fullCalendar({
                firstDay: 1,
                showNonCurrentDates: false,
                customButtons: {
                    timeslip: {
                        text: 'Timeslip (Peribadi)',
                        click: function() {
                            $('#modal-default-timeslip').modal({
                                backdrop: 'static',
                            });
                        }
                    },
                    catatan: {
                        text: 'Catatan (Rasmi)',
                        click: function() {
                            $('#modal-default-catatan').modal({
                                backdrop: 'static',
                            });
                        }
                    },
                    laporan: {
                        text: 'Laporan Bulanan',
                        click: function() {
                            exportPDF_laporanbulananDashboard(
                                _.filter(gEvents.data, {
                                    'table': 'final'
                                })
                            );
                        }
                    }
                },
                header: {
                    right: 'timeslip catatan laporan  prev,today,next'
                },
                dayClick: function(date, jsEvent, view) {
                    var modal = $('#modal-acara-anggota');
                    dateClick = date;

                    modal.find('.modal-title').html("MAKLUMAT ACARA PADA : " + date.format(
                        'D MMMM YYYY').toUpperCase());
                    modal.modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                },
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: base_url + 'rpc/kalendar/{{ Auth::user()->anggota_id }}',
                        data: {
                            start: start.toISOString(),
                            end: end.toISOString()
                        },
                        success: function(events) {
                            gEvents = events;
                            callback(events.data);
                        }
                    });
                },
                loading: function(isLoading, view) {
                    if (isLoading)
                        $('.overlay').show();
                    else
                        $('.overlay').hide();
                },
                eventRender: function(event, element, view) {
                    element.find('.fc-title').html(event.title);
                }
            });

            $('#tambah-acara').on('click', function(e) {
                $('#modal-default').modal({
                    backdrop: 'static',
                });
            })

            $('#modal-default').on('show.bs.modal', function(e) {
                var modalBody = $(this).find('.modal-body');

                $.ajax({
                    url: base_url +
                        'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara/create_default',
                    success: function(data, textStatus, jqXHR) {
                        modalBody.html(data);
                        $('#txtMasaMula').datetimepicker({
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $('#txtMasaTamat').datetimepicker({
                            useCurrent: false, //Important! See issue #1075
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $("#txtMasaMula").on("dp.change", function(e) {
                            acara.masaMula = e.date.format('YYYY-MM-DD HH:mm:00.000');
                            $('#txtMasaTamat').data("DateTimePicker").minDate(e.date);
                        });
                        $("#txtMasaTamat").on("dp.change", function(e) {
                            var duration = moment.duration(moment(e.date.format(
                                'YYYY-MM-DD HH:mm:00.000')).diff(acara
                                .masaMula));
                            duration = duration.asHours();

                            if (duration >= 4) {
                                e.target.value = '';
                                alert('Tempoh masa lebih 4 jam');
                                return;
                            }

                            acara.masaTamat = e.date.format('YYYY-MM-DD HH:mm:00.000');
                            $('#txtMasaMula').data("DateTimePicker").maxDate(e.date);
                        });
                    },
                });
            });






            $('#modal-default').on('change', '#txtPerkara', function(e) {
                acara.perkara = e.target.value;
            });


            $('#modal-default').on('change', '#txtKeterangan', function(e) {
                acara.keterangan = e.target.value;
            });




            $('#modal-default-timeslip').on('change', '#txtPerkara', function(e) {
                acara.perkara = e.target.value;
            });

            $('#modal-default-catatan').on('change', '#txtPerkaraC', function(e) {
                acara.perkara = e.target.value;
            });



            $('#modal-default-timeslip').on('change', '#txtKeterangan', function(e) {
                acara.keterangan = e.target.value;
            });

            $('#modal-default-catatan').on('change', '#txtKeteranganC', function(e) {
                acara.keterangan = e.target.value;
            });

            $('#modal-default').on('submit', '#frm-acara', function(e) {
                e.preventDefault();

                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menambah acara ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve, reject) => {
                            acara.jenisAcara = '{{ $Acara::KATEGORI_TIMESLIP }}';
                            $.ajax({
                                method: 'POST',
                                data: acara,
                                url: base_url +
                                    'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara',
                                success: function(acara, extStatus, jqXHR) {
                                    resolve({
                                        'acara': acara.data
                                    });
                                },
                                error: function(jqXHR, textStatus,
                                    errorThrown) {
                                    reject(textStatus);
                                },
                                statusCode: login()
                            });
                        });
                    }
                }).then((result) => {
                    console.log(result.value);
                    if (result.value) {
                        //cal.fullCalendar('refetchEvents');
                        cal.fullCalendar('renderEvent', result.value.acara);
                        $('#modal-default').modal('hide');

                        swal({
                            title: 'Berjaya!',
                            text: 'Maklumat telah disimpan',
                            type: 'success'
                        });
                    }
                }).catch((error) => {
                    console.log(error);
                    swal({
                        title: 'Ralat!',
                        text: "Operasi tidak berjaya!.\nSila berhubung dengan Pentadbir sistem",
                        type: 'error'
                    });
                });
            });

            // modal acara
            $('#modal-acara-anggota').on('show.bs.modal', function(e) {
                detailAcara(this);
            });

            $('#modal-acara-anggota').on('hidden.bs.modal', function(e) {
                $(this).find('.modal-body').html(
                    '<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
            });

            /* $('#modal-acara-anggota').on('click', '.btn-justifikasi', function(e) {
                var count = $('.btn-justifikasi');
                alert(count.length);
            }); */

            $('#modal-acara-anggota').on('change', '#chk-sama-petang', function(e) {
                e.preventDefault();

                if ($(this).is(':checked')) {

                    return disableFormComponentPetang(true);
                }

                return disableFormComponentPetang(false);
            });

            $('#modal-acara-anggota').on('change', '#chk-sama-pagi', function(e) {
                e.preventDefault();

                if ($(this).is(':checked')) {
                    return disableFormComponentPagi(true);
                }

                return disableFormComponentPagi(false);
            });

            $('#modal-acara-anggota').on('submit', '#frm-mohon-justifikasi-pagi', function(e) {
                e.preventDefault();
                if ($(e.target['chk-sama-petang']).is(':checked')) {
                    frmJustifikasi.sama = '{{ $Justifikasi::FLAG_JUSTIKASI_SAMA }}'
                }
                hantarJustifikasi(e);
            });

            $('#modal-acara-anggota').on('submit', '#frm-mohon-justifikasi-petang', function(e) {
                e.preventDefault();
                if ($(e.target['chk-sama-pagi']).is(':checked')) {
                    frmJustifikasi.sama = '{{ $Justifikasi::FLAG_JUSTIKASI_SAMA }}'
                }
                hantarJustifikasi(e);
            });

            $('#cetak-laporan-bulanan').on('click', function(e) {
                var tkhSemasaView = cal.fullCalendar('getDate');
                var bulan = tkhSemasaView.format('MM');
                var tahun = tkhSemasaView.format('YYYY');
            });

            $('#modal-default-timeslip').on('show.bs.modal', function(e) {
                var modalBody = $(this).find('.modal-body');

                $.ajax({
                    url: base_url +
                        'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara/create_timeslip',
                    success: function(data, textStatus, jqXHR) {
                        modalBody.html(data);
                        $('#txtMasaMula').datetimepicker({
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $('#txtMasaTamat').datetimepicker({
                            useCurrent: false, //Important! See issue #1075
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $("#txtMasaMula").on("dp.change", function(e) {
                            acara.masaMula = e.date.format('YYYY-MM-DD HH:mm:00.000');
                            $('#txtMasaTamat').data("DateTimePicker").minDate(e.date);
                        });
                        $("#txtMasaTamat").on("dp.change", function(e) {
                            var duration = moment.duration(moment(e.date.format(
                                'YYYY-MM-DD HH:mm:00.000')).diff(acara
                                .masaMula));
                            duration = duration.asHours();

                            if (duration >= 4) {
                                e.target.value = '';
                                alert('Tempoh masa lebih 4 jam');
                                return;
                            }

                            acara.masaTamat = e.date.format('YYYY-MM-DD HH:mm:00.000');
                            $('#txtMasaMula').data("DateTimePicker").maxDate(e.date);
                        });
                    },
                });
            });


            $('#modal-default-catatan').on('show.bs.modal', function(e) {
                var modalBody = $(this).find('.modal-body');

                $.ajax({
                    url: base_url +
                        'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara/create_catatan',
                    success: function(data, textStatus, jqXHR) {
                        modalBody.html(data);
                        $('#txtMasaMulaC').datetimepicker({
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $('#txtMasaTamatC').datetimepicker({
                            useCurrent: false, //Important! See issue #1075
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $("#txtMasaMulaC").on("dp.change", function(e) {
                            acara.masaMula = e.date.format('YYYY-MM-DD HH:mm:00.000');
                            $('#txtMasaTamatC').data("DateTimePicker").minDate(e.date);
                        });

                        $("#txtMasaTamatC").on("dp.change", function(e) {
                            acara.masaTamat = e.date.format('YYYY-MM-DD HH:mm:00.000');
                            $('#txtMasaMulaC').data("DateTimePicker").maxDate(e.date);
                        });
                    },
                });
            });



            $('#modal-default-timeslip').on('submit', '#frm-acara', function(e) {
                e.preventDefault();

                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menambah acara ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve, reject) => {
                            acara.jenisAcara = '{{ $Acara::KATEGORI_TIMESLIP }}';
                            $.ajax({
                                method: 'POST',
                                data: acara,
                                url: base_url +
                                    'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara',
                                success: function(acara, extStatus, jqXHR) {
                                    resolve({
                                        'acara': acara.data
                                    });
                                },
                                error: function(jqXHR, textStatus,
                                    errorThrown) {
                                    reject(textStatus);
                                },
                                statusCode: login()
                            });
                        });
                    }
                }).then((result) => {
                    console.log(result.value);
                    if (result.value) {
                        //cal.fullCalendar('refetchEvents');
                        cal.fullCalendar('renderEvent', result.value.acara);
                        $('#modal-default-timeslip').modal('hide');

                        swal({
                            title: 'Berjaya!',
                            text: 'Maklumat telah disimpan',
                            type: 'success'
                        });
                    }
                }).catch((error) => {
                    swal({
                        title: 'Ralat!',
                        text: "Operasi tidak berjaya!.\nSila berhubung dengan Pentadbir sistem",
                        type: 'error'
                    });
                });
            });

            $('#modal-default-catatan').on('submit', '#frm-acara', function(e) {
                e.preventDefault();

                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menambah acara ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve, reject) => {
                            acara.jenisAcara = '{{ $Acara::KATEGORI_CATATAN }}';
                            $.ajax({
                                method: 'POST',
                                data: acara,
                                url: base_url +
                                    'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara',
                                success: function(acara, extStatus, jqXHR) {
                                    resolve({
                                        'acara': acara.data
                                    });
                                },
                                error: function(jqXHR, textStatus,
                                    errorThrown) {
                                    reject(textStatus);
                                },
                                statusCode: login()
                            });
                        });
                    }
                }).then((result) => {
                    console.log(result.value);
                    if (result.value) {
                        //cal.fullCalendar('refetchEvents');
                        cal.fullCalendar('renderEvent', result.value.acara);
                        $('#modal-default-catatan').modal('hide');

                        swal({
                            title: 'Berjaya!',
                            text: 'Maklumat telah disimpan',
                            type: 'success'
                        });
                    }
                }).catch((error) => {
                    swal({
                        title: 'Ralat!',
                        text: "Operasi tidak berjaya!.\nSila berhubung dengan Pentadbir sistem",
                        type: 'error'
                    });
                });
            });

            function disableFormComponentPetang(status) {
                $('#frm-mohon-justifikasi-petang').trigger('reset');
                $('#chk-sama-pagi').prop('disabled', status);
                $('#txt-justifikasi-petang').prop('disabled', status);
                $('#btn-justifikasi-petang').prop('disabled', status);
            }

            function disableFormComponentPagi(status) {
                $('#frm-mohon-justifikasi-pagi').trigger('reset');
                $('#chk-sama-petang').prop('disabled', status);
                $('#txt-justifikasi-pagi').prop('disabled', status);
                $('#btn-justifikasi-pagi').prop('disabled', status);
            }

            function hantarJustifikasi(e) {
                frmJustifikasi.finalAttendance = e.target['txt-final-attendance-id'].value;
                frmJustifikasi.tarikh = e.target['txt-tarikh'].value;
                frmJustifikasi.alasan = e.target['txt-justifikasi'].value;
                frmJustifikasi.medanKesalahan = e.target['txt-medan-kesalahan'].value;

                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk memohon justifikasi ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve, reject) => {
                            $.ajax({
                                method: 'POST',
                                data: frmJustifikasi,
                                url: base_url +
                                    'rpc/justifikasi/{{ Auth::user()->anggota_id }}',
                                success: function(justifikasi, extStatus, jqXHR) {
                                    resolve();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    reject(jqXHR);
                                },
                                statusCode: login()
                            });
                        });
                    }
                }).then(() => {
                    $('#modal-acara-anggota').find('.modal-body').html(
                        '<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
                    detailAcara($('#modal-acara-anggota'));
                    swal({
                        title: 'Berjaya!',
                        text: 'Maklumat telah disimpan',
                        type: 'success'
                    });
                }).catch((error) => {
                    console.log(error.responseText);
                    swal({
                        title: 'Ralat!',
                        html: "Operasi tidak berjaya!<br/>" + error.responseText +
                            ".<br/>Sila berhubung dengan Pentadbir sistem.",
                        type: 'error'
                    });
                });
            }

            function detailAcara(container) {
                $.ajax({
                    url: base_url + 'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara/' + dateClick
                        .format('YYYY-MM-DD'),
                    success: (resp, text, jqXHR) => {
                        $(container).find('.modal-body').html(resp);

                        $.each($('.txt-tarikh'), (key, el) => {
                            $(el).val(dateClick.format('YYYY-MM-DD') + ' 00:00:00');
                        });

                        var maxLength = 300;
                        $(".show-read-more").each(function() {
                            var myStr = $(this).text();
                            if ($.trim(myStr).length > maxLength) {
                                var newStr = myStr.substring(0, maxLength);
                                var removedStr = myStr.substring(maxLength, $.trim(myStr)
                                    .length);
                                $(this).empty().html(newStr);
                                $(this).append(
                                    ' <a href="javascript:void(0);" class="read-more">read more...</a>'
                                );
                                $(this).append('<span class="seterusnya-text">' + removedStr +
                                    '</span>');
                            }
                        });
                        $(".read-more").click(function() {
                            $(this).siblings(".seterusnya-text").contents().unwrap();
                            $(this).remove();
                        });
                    }
                })
            }


            function exportPDF_laporanbulananDashboard(result) {


            }


            function exportPDF(result) {
                try {
                    var doc = new jsPDF('p', 'pt', 'a4');
                    var head = [
                        ["TARIKH", "MASUK", "KELUAR", "JAM", "KESALAHAN", "CATATAN", "TT"]
                    ];
                    var body = dataProvider(result);

                    var totalPagesExp = "{total_pages_count_string}";

                    doc.autoTable({
                        head,
                        body,
                        theme: 'grid',
                        showHead: 'firstPage',
                        margin: {
                            top: 75,
                            bottom: 85
                        },
                        headStyles: {
                            fontSize: 8
                        },
                        columnStyles: {
                            0: {
                                cellWidth: 50,
                                fontSize: 8
                            },
                            1: {
                                halign: "center",
                                fontSize: 8
                            },
                            2: {
                                halign: "center",
                                fontSize: 8
                            },
                            3: {
                                halign: "center",
                                fontSize: 8
                            },
                            4: {
                                cellWidth: 80,
                                fontSize: 8
                            },
                            5: {
                                cellWidth: 170,
                                fontSize: 8
                            }
                        },
                        didParseCell: function(data) {
                            if (data.row.section == 'head') {
                                data.cell.styles.fillColor = [54, 54, 54];
                                data.cell.styles.halign = "center";

                                if (data.column.dataKey === '0') {
                                    data.cell.styles.halign = "left";
                                }

                                if (data.column.dataKey === '4') {
                                    data.cell.styles.halign = "left";
                                }
                            }

                            if (moment(result[data.row.index].start).format('d') === '0' || moment(
                                    result[data.row.index].start).format('d') === '6' || result[data.row
                                    .index].cuti) {
                                if (data.row.section == 'body') {
                                    data.cell.styles.fillColor = [240, 240, 240];
                                }
                            }

                            if (data.row.section == 'body' && data.column.dataKey == '0') {
                                console.log(result[data.row.index].start);
                                data.cell.text = moment(result[data.row.index].start).format(
                                    'DD (ddd)');
                            }

                            if (data.row.section == 'body' && data.column.dataKey == '4') {
                                var justifikasi = '';
                                console.log("huhu");
                                if (result[data.row.index].tatatertib_flag == 'TS') {
                                    var kesalahan = JSON.parse(result[data.row.index].kesalahan);

                                    kesalahan.forEach(function(item, index) {
                                        switch (item) {
                                            case 'NONEIN':
                                                justifikasi += "Pg : Tiada rekod\r\n";
                                                break;
                                            case 'LEWAT':
                                                justifikasi += "Pg : Hadir lewat\r\n";
                                                break;
                                            case 'NONEOUT':
                                                justifikasi += "Ptg : Tiada rekod\r\n";
                                                break;
                                            case 'AWAL':
                                                justifikasi += "Ptg : Pulang awal\r\n";
                                                break;
                                        }
                                    });
                                }

                                data.cell.text = justifikasi;
                            }

                            if (data.row.section == 'body' && data.column.dataKey == '5') {
                                var justifikasi = '';

                                if (result[data.row.index].cuti) {
                                    justifikasi += "Cuti Umum : " + result[data.row.index].cuti
                                        .perihal + "\r\n";
                                }

                                if (result[data.row.index].justifikasi) {
                                    result[data.row.index].justifikasi.forEach(function(item, index) {
                                        //if(index === 0 && item.flag_kelulusan === 'LULUS') {
                                        if (index == 0) {
                                            if (item.flag_justifikasi === 'SAMA') {
                                                justifikasi += "J : " + item.keterangan +
                                                    "\r\n";
                                            } else {
                                                justifikasi += "JPG : " + item.keterangan +
                                                    "\r\n";
                                            }
                                        }

                                        //if(index === 1 && item.flag_kelulusan === 'LULUS' && item.flag_justifikasi === 'XSAMA') {
                                        if (index == 1 && item.flag_justifikasi == 'XSAMA') {
                                            justifikasi += "JPTG : " + item.keterangan + "\r\n";
                                        }
                                    });
                                }

                                data.cell.text = justifikasi;
                            }
                        },
                        didDrawPage: function(data) {
                            /* if (base64Img) {
                                doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 10, 10);
                            } */
                            doc.setFontSize(9);
                            doc.setFontStyle('normal');

                            var bulanLepas = cal.fullCalendar('getDate').subtract(1, "months");

                            console.log(bulanLepas.format('M'), bulanLepas.format('YYYY'));

                            function getWarnaBulanan(bulan, tahun) {
                                return $.ajax({
                                    type: "GET",
                                    url: base_url +
                                        "rpc/warnakad/{{ Auth::user()->xtraAnggota->anggota_id }}/" +
                                        bulan + "/" + tahun,
                                    async: false
                                }).responseText;
                            }

                            doc.text("LAPORAN KEHADIRAN BULANAN", data.settings.margin.left, 30);
                            doc.text("Nama : " + "{{ Auth::user()->xtraAnggota->nama }}", data
                                .settings.margin.left, 40);
                            doc.text("Jabatan/ Bahagian/ Unit : " +
                                "{{ Auth::user()->xtraAnggota->department->deptname }}", data
                                .settings.margin.left, 50);
                            doc.text("Bulan : " + cal.fullCalendar('getDate').format('MMMM YYYY'), data
                                .settings.margin.left, 60);
                            doc.text("Warna Kad : " + getWarnaBulanan(bulanLepas.format('M'), bulanLepas
                                .format('YYYY')), data.settings.margin.left, 70);

                            doc.setFontSize(9);
                            // Footer
                            var str = "Muka " + doc.internal.getNumberOfPages()

                            // Total page number plugin only available in jspdf v1.0+
                            if (typeof doc.putTotalPages === 'function') {
                                str = str + " drp " + totalPagesExp;
                            }

                            doc.setFontSize(9);

                            // jsPDF 1.4+ uses getWidth, <1.4 uses .width
                            var pageSize = doc.internal.pageSize;
                            var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                            var pageWidth = doc.internal.pageSize.width ? doc.internal.pageSize.width :
                                doc.internal.pageSize.getWidth();

                            doc.text("T/ T PEGAWAI", data.settings.margin.left, pageHeight - 70);
                            doc.writeText(data.settings.margin.left - 80, pageHeight - 70,
                                "T/ T KETUA UNIT/ BAHAGIAN", {
                                    align: 'right'
                                });
                            doc.text("Tarikh :", data.settings.margin.left, pageHeight - 40);
                            doc.writeText(data.settings.margin.left - 175, pageHeight - 40,
                                "Tarikh :", {
                                    align: 'right'
                                });

                            doc.text("{{ env('APP_NAME') }}", data.settings.margin.left, pageHeight -
                                20);
                            doc.text("Dicetak pada : " + moment().format("lll") +
                                ", Oleh : {{ Auth::user()->xtraAnggota ? Auth::user()->xtraAnggota->nama : Auth::user()->name }}",
                                data.settings.margin.left, pageHeight - 10, 'left');
                            doc.writeText(data.settings.margin.left + 20, pageHeight - 10, str, {
                                align: 'right'
                            });
                        }
                    });

                    // Total page number plugin only available in jspdf v1.0+
                    if (typeof doc.putTotalPages === 'function') {
                        doc.putTotalPages(totalPagesExp);
                    }

                    doc.output("dataurlnewwindow");
                    //pdf.save();
                } catch (error) {
                    console.log(error);
                    swal({
                        title: 'Ralat!',
                        html: "Janaan tidak berjaya!.<br/>Sila pastikan data kehadiran wujud.",
                        type: 'error'
                    });
                }
            }

            function dataProvider(result) {
                return result.map((item) => [
                    moment(item.start).format("DD (ddd)"),
                    (item.checkIn) ? moment(item.checkIn).format("h:mm A") : '',
                    (item.checkOut) ? moment(item.checkOut).format("h:mm A") : '',
                    item.jumlah_jam,
                    '',
                    ''
                ]);
            }

            var appBdrCheckInOut = new Vue({
                el: '#app-bdr-check-inout',
                data: {
                    checkIn: null,
                    checkOut: null,
                },
                computed: {
                    isCheckIn: function() {
                        return (this.checkIn) ? true : false;
                    },
                    isCheckOut: function() {
                        return (this.checkOut) ? true : false;
                    },
                    checkInDate: function() {

                        if (this.checkIn) {
                            return moment(this.checkIn).format("DD-MMM-YYYY");
                        }

                        return "-";
                    },
                    checkInTime: function() {

                        if (this.checkIn) {
                            return moment(this.checkIn).format("hh:mm A");
                        }

                        return "-";
                    },
                    checkOutDate: function() {

                        if (this.checkOut) {
                            return moment(this.checkOut).format("DD-MMM-YYYY");
                        }

                        return "-";
                    },
                    checkOutTime: function() {

                        if (this.checkOut) {
                            return moment(this.checkOut).format("hh:mm A");
                        }

                        return "-";
                    }
                },
                methods: {
                    checkingIn() {
                        if (!this.checkIn) {
                            $.ajax({
                                method: "POST",
                                url: base_url +
                                    "rpc/kalendar/{{ Auth::user()->anggota_id }}/checkingin",
                                success: response => {
                                    this.checkIn = moment(response.checktime.date).format();
                                },
                                error: response => {
                                    console.log(response);
                                }
                            });
                        }
                    },
                    checkingOut() {
                        if (!this.checkOut) {
                            $.ajax({
                                method: "POST",
                                url: base_url +
                                    "rpc/kalendar/{{ Auth::user()->anggota_id }}/checkingout",
                                success: response => {
                                    this.checkOut = moment(response.checktime.date).format();
                                },
                                error: response => {
                                    console.log(response);
                                }
                            });
                        }
                    }
                },
                created() {
                    $.ajax({
                        url: base_url + "rpc/kalendar/{{ Auth::user()->anggota_id }}/checkinout",
                        success: response => {
                            this.checkIn = response.in ? moment(response.in.checktime.date)
                                .format() : null;
                            this.checkOut = response.out ? moment(response.out.checktime.date)
                                .format() : null;
                        },
                        error: response => {
                            console.log(response);
                        }
                    });
                },
            });
        });
    </script>

    <script>
        $(function() {
            $(".btn-hapus-acara").on('click', function(e) {
                e.preventDefault();

                penghapusan(this, '{{ $Acara::STATUS_PERMOHONAN_BATAL }}')
            });

            function penghapusan(el, status) {
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
                        return new Promise((resolve, reject) => {
                            $.ajax({
                                method: 'POST',
                                data: {
                                    '_method': 'PUT',
                                    status: status
                                },
                                url: base_url + 'rpc/justifikasi/' + id,
                                success: function(data, extStatus, jqXHR) {
                                    resolve({
                                        value: true
                                    });
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
                }).catch(function(error) {
                    swal({
                        title: 'Ralat!',
                        text: 'Pembatalan permohonan tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                        type: 'error'
                    });
                });
            }
        });
    </script>
@endsection
