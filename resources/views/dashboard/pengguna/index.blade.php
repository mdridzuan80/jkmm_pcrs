@extends('layouts.master')
@inject('Justifikasi', 'App\Justifikasi')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-dashboard"></i></i> Dashboard
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
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
    
        <div class="modal fade" id="modal-default" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: steelblue; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"><i class="fa fa-fw fa-calendar-plus-o"></i> TAMBAH ACARA</h4>
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
                    /*aktiviti: {
                        text: 'Tambah Aktiviti',
                        click: function() {
                            $('#modal-default').modal({backdrop: 'static',});
                        }
                    },*/
                    laporan: {
                        text: 'Laporan Bulanan',
                        click: function() {
                            exportPDF(
                                _.filter(gEvents.data, { 'table': 'final' })
                            );
                        }
                    }
                },
                header: {
                    right: 'laporan aktiviti prev,today,next'
                },
                dayClick: function(date, jsEvent, view) {
                    var modal = $('#modal-acara-anggota');
                    dateClick = date;

                    modal.find('.modal-title').html("MAKLUMAT ACARA PADA : " + date.format('D MMMM YYYY').toUpperCase());
                    modal.modal({backdrop: 'static',keyboard: false});
                },
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: base_url+'rpc/kalendar/{{Auth::user()->anggota_id}}',
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
                loading: function(isLoading, view)
                {
                    if (isLoading)
                        $('.overlay').show();
                    else
                        $('.overlay').hide();
                },
                eventRender: function(event, element, view ) {
                    element.find('.fc-title').html(event.title);
                }
            });

            $('#tambah-acara').on('click', function(e) {
                $('#modal-default').modal({backdrop: 'static',});
            })

            $('#modal-default').on('show.bs.modal', function(e) {
                var modalBody = $(this).find('.modal-body');

                $.ajax({
                    url: base_url + 'rpc/kalendar/{{Auth::user()->anggota_id}}/acara/create',
                    success: function(data, textStatus, jqXHR) {
                        modalBody.html(data);
                        $('#txtMasaMula').datetimepicker({
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $('#txtMasaTamat').datetimepicker({
                            useCurrent: false, //Important! See issue #1075
                            format: 'DD/MM/YYYY h:mm A'
                        });
                        $("#txtMasaMula").on("dp.change", function (e) {
                            acara.masaMula = e.date.format('YYYY-MM-DD HH:mm:00.000');
                            $('#txtMasaTamat').data("DateTimePicker").minDate(e.date);
                        });
                        $("#txtMasaTamat").on("dp.change", function (e) {
                            var duration = moment.duration(moment(e.date.format('YYYY-MM-DD HH:mm:00.000')).diff(acara.masaMula));
                            duration = duration.asHours();

                            if (acara.jenisAcara == '{{ \App\Acara::JENIS_ACARA_TIDAK_RASMI}}' && duration > 4)
                            {
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

            $('#modal-default').on('hidden.bs.modal', function(e) {
                e.preventDefault();
                $(this).find('.modal-title').html('<i class="fa fa-fw fa-calendar-plus-o"></i> TAMBAH ACARA');
                $(this).find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
            });

            $('#modal-default').on('click', 'input[type="radio"]', function(e) {
                acara.jenisAcara = e.target.value;
            });

            $('#modal-default').on('keyup', '#txtPerkara', function(e) {
                acara.perkara = e.target.value;
                if(! e.target.value) {
                    return $('#modal-default .modal-title').html('<i class="fa fa-fw fa-calendar-plus-o"></i> TAMBAH ACARA');
                }

                return $('#modal-default .modal-title').html('<i class="fa fa-fw fa-calendar"></i>' + e.target.value.toUpperCase());
            });

            $('#modal-default').on('change', '#txtKeterangan', function(e) {
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
                        return new Promise((resolve,reject) => {
                            $.ajax({
                                method: 'POST',
                                data: acara,
                                url: base_url + 'rpc/kalendar/{{Auth::user()->anggota_id}}/acara',
                                success: function(acara, extStatus, jqXHR) {
                                    resolve({'acara': acara.data});
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
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
                        cal.fullCalendar( 'renderEvent', result.value.acara);
                        $('#modal-default').modal('hide');

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

            // modal acara
             $('#modal-acara-anggota').on('show.bs.modal', function(e) {                
                detailAcara(this);
            });

            $('#modal-acara-anggota').on('hidden.bs.modal', function(e) {
                $(this).find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
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
                        return new Promise((resolve,reject) => {
                            $.ajax({
                                method: 'POST',
                                data: frmJustifikasi,
                                url: base_url + 'rpc/justifikasi/{{Auth::user()->anggota_id}}',
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
                    $('#modal-acara-anggota').find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
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
                        html: "Operasi tidak berjaya!<br/>"+error.responseText+".<br/>Sila berhubung dengan Pentadbir sistem.",
                        type: 'error'
                    });
                });
            }

            function detailAcara(container) {
                $.ajax({
                    url: base_url+'rpc/kalendar/{{ Auth::user()->anggota_id }}/acara/' + dateClick.format('YYYY-MM-DD'),
                    success: (resp, text, jqXHR) => {
                        $(container).find('.modal-body').html(resp);

                        $.each($('.txt-tarikh'), (key, el) => {
                            $(el).val(dateClick.format('YYYY-MM-DD')+' 00:00:00');                            
                        });

                        var maxLength = 300;
                        $(".show-read-more").each(function(){
                            var myStr = $(this).text();
                            if($.trim(myStr).length > maxLength){
                                var newStr = myStr.substring(0, maxLength);
                                var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                                $(this).empty().html(newStr);
                                $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
                                $(this).append('<span class="seterusnya-text">' + removedStr + '</span>');
                            }
                        });
                        $(".read-more").click(function(){
                            $(this).siblings(".seterusnya-text").contents().unwrap();
                            $(this).remove();
                        });
                    }
                })
            }

            function exportPDF(result) {
                try {     
                    var doc = new jsPDF('p', 'pt', 'a4');
                    var head = [["Tarikh", "Check-In", "Check-Out", "Catatan"]];
                    var body = result.map((item)=>[moment(item.start).format("DD-MM-YYYY"), (item.checkIn) ? moment(item.checkIn).format("h:mm A") : '', (item.checkOut) ? moment(item.checkOut).format("h:mm A") : '', '']);
                    
                    var totalPagesExp = "{total_pages_count_string}";

                    doc.autoTable({
                        head,
                        body,
                        theme: 'grid',
                        showHead: 'firstPage',
                        margin: {top: 80},
                        columnStyles: {
                            0: {cellWidth:1},
                            1: {cellWidth:1},
                            2: {cellWidth:1},
                            3: {cellWidth:'auto'}
                        },
                        didParseCell: function(data) {
                            if(moment(result[data.row.index].start).format('d') === '0' || moment(result[data.row.index].start).format('d') === '6' || result[data.row.index].cuti ) {
                                if (data.row.index === data.row.index) {
                                    data.cell.styles.fillColor = [240, 240, 240];
                                }
                            }

                            if (data.row.section === 'body' && data.column.dataKey === '0') {
                                data.cell.text = moment(result[data.row.index].start).format('DD-MMM-YYYY (ddd)');
                            }

                            if (data.row.section === 'body' && data.column.dataKey === '3') {
                                var justifikasi = '';
                                
                                if(result[data.row.index].cuti) {
                                    justifikasi += "Cuti Umum : " + result[data.row.index].cuti.perihal + "\n";
                                }

                                if(result[data.row.index].justifikasi) {
                                    result[data.row.index].justifikasi.forEach(function(item, index) {
                                        if(index === 0 && item.flag_kelulusan === 'LULUS') {
                                            if(item.flag_justifikasi === 'SAMA') {
                                                justifikasi += "Justifikasi : " + item.keterangan + "\n";
                                            } else {
                                                justifikasi += "Justifikasi Pagi : " + item.keterangan + "\n";
                                            }
                                        }

                                        if(index === 1 && item.flag_kelulusan === 'LULUS' && item.flag_justifikasi === 'XSAMA') {
                                            justifikasi += "Justifikasi Petang : " + item.keterangan + "\n";
                                        }
                                    });
                                }

                                data.cell.text = justifikasi;
                            }
                        },
                        didDrawPage: function (data) {
                            // Header
                            doc.setFontSize(16);
                            doc.setTextColor(40);
                            doc.setFontStyle('normal');
                            /* if (base64Img) {
                                doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 10, 10);
                            } */                        
                            doc.setFontSize(12);
                            doc.text("LAPORAN KEHADIRAN BULANAN", data.settings.margin.left, 30);
                            doc.text("Nama : " + "{{ Auth::user()->xtraAnggota->nama }}", data.settings.margin.left, 45);
                            doc.text("Jabatan/ Bahagian/ Unit : " + "{{ Auth::user()->xtraAnggota->department->deptname }}", data.settings.margin.left, 60);
                            doc.text("Bulan : " + cal.fullCalendar('getDate').format('MMMM YYYY'), data.settings.margin.left, 75);

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
                            var pageWidth = doc.internal.pageSize.width ? doc.internal.pageSize.width : doc.internal.pageSize.getWidth();

                            doc.text("{{ env('APP_NAME') }}", data.settings.margin.left, pageHeight - 20);
                            doc.text("Dicetak pada : "+moment().format("lll"), data.settings.margin.left, pageHeight - 10, 'left');
                            doc.writeText(data.settings.margin.left + 20, pageHeight - 10 ,str, { align: 'right' });
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
        });
    </script>
@endsection