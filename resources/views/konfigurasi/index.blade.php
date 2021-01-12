@inject('Flow', 'App\Flow')

@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>
        <i class="fa fa-gear"></i></i> Konfigurasi
        <small>Menguruskan konfigurasi sistem yang berkaitan</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= route('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Konfigurasi</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Sistem</a></li>
                    @can('view-cuti')
                        <li><a id="tab_cuti" href="#tab_2">Cuti Umum</a></li>
                    @endcan
                    @can('view-shift')
                        <li><a id="tab_waktu_bekerja" href="#tab_3" >Waktu Bekerja</a></li>
                    @endcan
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td style="width: 40%">
                                                <b>Flow Kelulusan Bahagian/ Unit</b>
                                                <p class="help-block">
                                                    Memastikan flow kelulusan mengikut keperluan bahagian atau unit.
                                                    <ul class="list-unstyled">
                                                        <li>'BIASA' adalah flow mengikut Penilai Pertama. (*)</li>
                                                        <li>'KETUA' adalah flow semua permohonan diluluskan oleh Ketua Bahagian/ Unit.</li>
                                                    </ul>
                                                    
                                                </p>
                                            </td>
                                            <td style="width: 60%">
                                                <table class="table" style="width: 100%; background-color: transparent;">
                                                    <tr>
                                                        <td>
                                                            <div style="position: relative;">
                                                                <input id="departmentDisplay" class="form-control departmentDisplay" type="text" style="background-color: #FFF;" readonly disabled placeholder="Bahagian/ Unit">
                                                                <input id="departmentDisplayId" name="txtDepartmentId" class="form-control departmentDisplayId" type="hidden" style="background-color: #FFF;" readonly>
                                                                <div id="treeDisplay" style="display:none; position: fixed;">
                                                                    <div id="departmentsTree" style="position:absolute; background-color: #FFF; overflow:auto; max-height:200px; border:1px #ddd solid"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div id="flow-bahagian-conf">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr id="app-puasa">
                                            <div v-cloak>
                                            <td style="width: 40%">
                                                <b>Tarikh Berpuasa</b>
                                                <p class="help-block">
                                                    Mengishtiharkan Tarikh permulaan dan tamat berpuasa
                                                </p>
                                            </td>
                                            <td style="width: 60%">
                                                <table class="table" style="width: 100%; background-color: transparent;">
                                                    <tr>
                                                        <td>
                                                            <input type="text" id="tkhPuasaMula" name="txtMula" class="form-control" placeholder="Tarikh Mula" v-model="tkhMula">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="tkhPuasaTamat" name="txtTamat" class="form-control" placeholder="Tarikh Tamat" v-model="tkhTamat">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info" @click="updateTarikh">Simpan</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <ol>
                                                            <li v-for="puasa of senPuasa" :key="puasa" >
                                                                Mula: @{{ puasa.tkhmula }} - Tamat: @{{ puasa.tkhtamat }} &nbsp;
                                                                <a title="Hapus Peranan" class="btn btn-danger btn-xs" @click="deleteTarikh(puasa.id)">
                                                                    <i class="fa fa-trash-o"></i>
                                                                </a>
                                                            </li>
                                                            </ol>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @can('view-cuti')
                            <div class="tab-pane" id="tab_2">
                                <div id="cuti_content"></div>
                            </div>
                        @endcan

                        @can('view-shift')
                            <div class="tab-pane" id="tab_3">
                                <div id="waktu_bekerja_content"></div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="overlay" style="display: none;">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>

    <!-- Modal --> 
    @can('view-shift')
        <div id="modal-shift-add" class="modal fade" >
            <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="frm-shift-add">
                    <div class="modal-header" style="background-color: steelblue; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-clock-o"></i> Tambah Waktu Bekerja</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="col-md-3"><b>NAMA WAKTU BERPERINGKAT</b></td>
                                    <td>
                                        <input class="form-control" type="text" name="txtPerihal" placeholder="Perihal" autocomplete="off" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>FLEKSI</b></td>
                                    <td>
                                        <select id="comFleksi" class="form-control" name="comFleksi" required="">
                                        <option value="YA">YA</option>
                                        <option value="TIDAK">TIDAK</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>WAKTU MULA</b></td>
                                    <td>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="txtWaktuMula" name="txtWaktuMula" type="text" class="form-control" required>
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>WAKTU TAMAT</b></td>
                                    <td>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="txtWaktuTamat" name="txtWaktuTamat" type="text" class="form-control" required>
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" style="color:#dd4b39;" data-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-success">SIMPAN</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endcan
    <!-- /.modal -->

    <!-- Modal --> 
    @can('view-shift')
        <div id="modal-shift-edit" class="modal fade" >
            <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="frm-shift-edit">
                    <div class="modal-header" style="background-color: steelblue; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-clock-o"></i> Kemaskini Waktu Bekerja</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="col-md-3"><b>NAMA WAKTU BERPERINGKAT</b></td>
                                    <td>
                                        <input class="form-control" type="text" name="txtPerihal" placeholder="Perihal" autocomplete="off" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><b>FLEKSI</b></td>
                                    <td>
                                        <select id="comFleksi" class="form-control" name="comFleksi" required="">
                                        <option value="YA">YA</option>
                                        <option value="TIDAK">TIDAK</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>WAKTU MULA</b></td>
                                    <td>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="txtWaktuMula2" name="txtWaktuMula" type="text" class="form-control" required>
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>WAKTU TAMAT</b></td>
                                    <td>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="txtWaktuTamat2" name="txtWaktuTamat" type="text" class="form-control" required>
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" style="color:#dd4b39;" data-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-success">SIMPAN</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endcan
    <!-- /.modal -->

    <!-- Modal --> 
    @can('view-cuti')
        <div id="modal-cuti-add" class="modal fade" >
            <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="background-color: steelblue; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-calendar"></i> Tambah/ Kemaskini Waktu Bekerja</h4>
                </div>
                <form id="frm-cuti-add">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><b>TARIKH</b></td>
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input id="txtTarikhCuti" name="txtTarikhCuti" type="text" class="form-control" autocomplete="off" required >
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>KETERANGAN</b></td>
                                <td><input id="txtPerihal" class="form-control" type="text" name="txtPerihal" placeholder="Perihal" required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" style="color:#dd4b39;" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-success">SIMPAN</button>
                </div>
                </form>              
            </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endcan
    <!-- /.modal -->


@endsection

@section('scripts')
    <script>
        $(function() {
            var shiftID = '';
            var cutiID= '';
            var tahun = new Date().getFullYear();     

            $('#txtWaktuMula').timepicker({
                showInputs: false
            })

            $('#txtWaktuTamat').timepicker({
                showInputs: false
            })

            $('#txtWaktuMula2').timepicker({
                showInputs: false
            })

            $('#txtWaktuTamat2').timepicker({
                showInputs: false
            })


            $('#txtTarikhCuti').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true
            }).on('hide', function(){
                $('.modal-backdrop').css('z-index', 1020);
            });

            $.ajax({
                url: base_url+'rpc/department_tree',
                dataType: 'json',
                success: function( result, textStatus, jqXHR ) {
                    departments = result;
                    $('#departmentDisplay').prop('disabled', false);

                    $('#departmentsTree').jstree({
                        core:{
                            multiple : false,
                            check_callback: true,
                            data: departments
                        }
                    });

                    $('#departmentsTree').on('select_node.jstree', function (e, data) {
                        var placeholder = $('#flow-bahagian-conf');
                        var id = data.instance.get_node(data.selected[0]).id;
                        var text = data.instance.get_node(data.selected[0]).text;

                        $('.departmentDisplay').val(text);
                        $('.departmentDisplayId').val(id);
                        $("#treeDisplay").hide();

                        $.ajax({
                            url: base_url + 'rpc/konfigurasi/flow_bahagian/' + id,
                            success: function( result, textStatus, jqXHR ) {
                                var option = $('<select id="com-flow-bahagian" class="form-control"></select>');
                                option.append('<option value="{{ $Flow::BIASA }}" ' + ((result.data.flow == '{{ $Flow::BIASA }}') ? '"selected"' : '') + '>{{ $Flow::BIASA }}</option>');
                                option.append('<option value="{{ $Flow::KETUA }}" ' + ((result.data.flow == '{{ $Flow::KETUA }}') ? '"selected"' : '') + '>{{ $Flow::KETUA }}</option>');
                                placeholder.html(option.val(result.data.flow));
                            }
                        });

                        $('#flow-bahagian-conf').on('change', '#com-flow-bahagian', function(e) {
                            e.preventDefault();
                            
                            $.ajax({
                                method: 'post',
                                data:{'flag': e.target.value},
                                url: base_url + 'rpc/konfigurasi/flow_bahagian/' + id,
                                success: function( result, textStatus, jqXHR ) {
                                    
                                }
                            });
                        });
                    });
                }
            });

            $('#departmentDisplay').on('click', function(e) {
                e.preventDefault();
                $('#departmentsTree').css('width', $(this).parent().actual('width'));
                $('#departmentsTree').jstree('select_node', $('.departmentDisplayId').val().toString());
                $('#treeDisplay').toggle();

                $(document).click(function (e) {
                    if (!$(e.target).hasClass("departmentDisplay") 
                        && $(e.target).parents("#treeDisplay").length === 0) 
                    {
                        $("#treeDisplay").hide();
                    }
                });
            });

            $('#tab_waktu_bekerja').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#tab_waktu_bekerja').on('shown.bs.tab', function(e) {
                var placeholder = $('#waktu_bekerja_content');

                populateDg(base_url+'rpc/waktu_bekerja','#waktu_bekerja_content')
            });

            $('#waktu_bekerja_content').on('click', '.btn-page', function(e) {
                e.preventDefault();
                $('#top-btn-wp-edit').prop('disabled', true);
                $('#top-btn-wp-delete').prop('disabled', true);

                url = $(this).attr('href');
                populateDg(url, '#waktu_bekerja_content');
            });

            $('#waktu_bekerja_content').on('click', '.row-shift', function(e) {
                var rows = $('#waktu_bekerja_content .row-shift');
                userRow = $(this);

                Object.values(rows).forEach(function(row)
                {
                    $(row).removeAttr('style');
                });

                shiftID = $(this).data('shiftid');
                
                $(this).css('background-color', '#c2eafe');

                $('#top-btn-wp-edit').prop('disabled', false);
                $('#top-btn-wp-delete').prop('disabled', false);

            });

            function populateDg(url, place) {
                $('.overlay').show();
                $.ajax({
                    method: 'get',
                    url: url,
                    success: function(data, textStatus, jqXHR) {
                        $('.overlay').hide();
                        $(place).html(data);

                        $('#top-btn-wp-edit').prop('disabled', true);
                        $('#top-btn-wp-delete').prop('disabled', true);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    },
                    statusCode: login()
                });
            }

            function populateDgCuti(url, place) {
                $('.overlay').show();
                $.ajax({
                    method: 'post',
                    url: url,
                    data:{tahun: tahun},
                    success: function(data, textStatus, jqXHR) {
                        $('.overlay').hide();
                        $(place).html(data);

                        $('#top-btn-wp-edit').prop('disabled', true);
                        $('#top-btn-wp-delete').prop('disabled', true);

                        $('#comTahun').on('change', function(e){
                            tahun = $(this).val();
                            populateDgCuti(base_url+'rpc/cuti','#cuti_content');
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    },
                    statusCode: login()
                });
            }

            $('#waktu_bekerja_content').on('click', '#top-btn-wp-add', function(e){                
                $('#modal-shift-add').modal();
            });

            $('#modal-shift-add').on('submit', '#frm-shift-add', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);

                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menambah maklumat ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve,reject) => {
                            $.ajax({
                                method: 'post',
                                data: formData,
                                cache       : false,
                                contentType : false,
                                processData : false,
                                url: base_url+'rpc/waktu_bekerja',
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
                    e.target.txtPerihal.value = '';

                    if (result.value) {
                        swal({
                            title: 'Berjaya!',
                            text: 'Maklumat telah dikemaskini',
                            type: 'success'
                        });
                        
                        populateDg(base_url+'rpc/waktu_bekerja','#waktu_bekerja_content')
                        $('#modal-shift-add').modal('hide');
                    }
                }).catch(function (error) {
                    swal({
                        title: 'Ralat!',
                        text: 'Aktiviti tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                        type: 'error'
                    });
                });
            });

            $('#modal-shift-edit').on('show.bs.modal', function(e) {
                $("body").css("cursor", "progress");
                $.ajax({
                    async: false,
                    url: base_url+'rpc/waktu_bekerja/'+shiftID,                
                    success: function(data) {
                        console.log(data);

                        $('#frm-shift-edit').find('[name="txtPerihal"]').val(data.data.name);
                        //$('#frm-shift-edit').find('[name="comFleksi"]').val(data.name);
                        $('#frm-shift-edit').find('[name="txtWaktuMula"]').val(data.data.starttime);
                        $('#frm-shift-edit').find('[name="txtWaktuTamat"]').val(data.data.endtime);
                    },
                    error: function(err) {
                        swal({
                            title: 'Ralat!',
                            text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                            type: 'error'
                        });
                    },
                    statusCode: login()
                });
                $("body").css("cursor", "default");
            });

            $('#waktu_bekerja_content').on('click', '#top-btn-wp-edit', function(e) {

                $('#modal-shift-edit').modal();
            });

            $('#waktu_bekerja_content').on('click', '#top-btn-wp-delete', function(e) {
                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menghapuskan maklumat ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve, reject) => {

                            $.ajax({
                                method: 'post',
                                data: {'_method': 'DELETE'},
                                url: base_url+'rpc/waktu_bekerja/'+shiftID,                
                                success: function() {
                                    swal({
                                        title: 'Berjaya!',
                                        text: 'Maklumat telah dihapuskan!',
                                        type: 'success'
                                    });
                                    
                                    populateDg(base_url+'rpc/waktu_bekerja','#waktu_bekerja_content')
                                },
                                error: function(err) {
                                    swal({
                                        title: 'Ralat!',
                                        text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                                        type: 'error'
                                    });
                                },
                                statusCode: login()
                            });
                        })
                    }
                });
            });

            // cuti
            var tabCuti = $('#tab_cuti');
            tabCuti.on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            tabCuti.on('shown.bs.tab', function(e) {                
                populateDgCuti(base_url+'rpc/cuti','#cuti_content');                
            });

            var cutiContent = $('#cuti_content');
            cutiContent.on('click', '.row-item', function(e) {
                var rows = $('#cuti_content .row-item');
                userRow = $(this);

                Object.values(rows).forEach(function(row)
                {
                    $(row).removeAttr('style');
                });

                cutiID = $(this).data('id');

                $('#modal-cuti-add').find('#txtTarikhCuti').val(moment($(this).data('tarikh'), "DD-MM-YYYY").format('YYYY-MM-DD'));
                $('#modal-cuti-add').find('#txtPerihal').val($(this).data('perihal'));
                
                $(this).css('background-color', '#c2eafe');

                $('#top-btn-cuti-edit').prop('disabled', false);
                $('#top-btn-cuti-delete').prop('disabled', false);
            });

            $('#cuti_content').on('click', '#top-btn-cuti-add', function(e){
                $('#modal-cuti-add').find('#txtTarikhCuti').val(null);
                $('#modal-cuti-add').find('#txtPerihal').val(null);
                  
                $('#modal-cuti-add').modal('show');
            });

            $('#cuti_content').on('click', '#top-btn-cuti-edit', function(e){                         
                $('#modal-cuti-add').modal('show');
            });

            $('#modal-cuti-add').on('submit', '#frm-cuti-add', function(e){
                e.preventDefault();
                
                //var form = this;
                var formData = new FormData(this);

                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menambah maklumat ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve,reject) => {
                            $.ajax({
                                method: 'post',
                                data: formData,
                                cache       : false,
                                contentType : false,
                                processData : false,
                                url: base_url+'rpc/cuti/add',
                                success: function(data, extStatus, jqXHR) {
                                    //form.trigger('reset');
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
                    e.target.txtPerihal.value = '';

                    if (result.value) {
                        swal({
                            title: 'Berjaya!',
                            text: 'Maklumat telah dikemaskini',
                            type: 'success'
                        });
                        
                        populateDgCuti(base_url+'rpc/cuti','#cuti_content')
                        $('#modal-cuti-add').modal('hide');
                    }
                }).catch(function (error) {
                    swal({
                        title: 'Ralat!',
                        text: 'Aktiviti tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                        type: 'error'
                    });
                });
            });
            
            $('#cuti_content').on('click', '#top-btn-cuti-delete', function(e){
                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menghapuskan maklumat ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: () => {
                        return new Promise((resolve, reject) => {

                            $.ajax({
                                method: 'post',
                                data: {'_method': 'DELETE', 'cutiId': cutiID},
                                url: base_url+'rpc/cuti',                
                                success: function() {
                                    swal({
                                        title: 'Berjaya!',
                                        text: 'Maklumat telah dihapuskan!',
                                        type: 'success'
                                    });
                                    
                                    populateDgCuti(base_url+'rpc/cuti','#cuti_content')
                                },
                                error: function(err) {
                                    swal({
                                        title: 'Ralat!',
                                        text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                                        type: 'error'
                                    });
                                },
                                statusCode: login()
                            });
                        })
                    }
                });
            });

            var appPuasa = new Vue({
                el: "#app-puasa",
                data: {
                    tkhMula: null,
                    tkhTamat: null,
                    senPuasa: []
                },
                methods: {
                    updateTarikh() {            
                        swal({
                            title: 'Amaran!',
                            text: 'Anda pasti untuk menambah rekod pengisytiharan puasa?',
                            type: 'warning',
                            cancelButtonText: 'Tidak',
                            showCancelButton: true,
                            confirmButtonText: 'Ya!',
                            showLoaderOnConfirm: true,
                            allowOutsideClick: () => !swal.isLoading(),
                            preConfirm: (email) => {
                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        method: "post",
                                        url: base_url + "rpc/puasa",
                                        data: {tkhMula: this.tkhMula, tkhTamat: this.tkhTamat},                
                                        success: function(result) {
                                            console.log(result);
                                            resolve(result);
                                        },
                                        error: function(result) {
                                            reject(result);
                                        },
                                        statusCode: login()
                                    });
                                })
                            }
                        }).then((result) => {
                            if (result.value) {
                                this.senPuasa.push(result.value.data);

                                this.tkhMula = null;
                                this.tkhTamat = null;
                            }
                        }).catch(function () {
                            swal({
                                title: 'Ralat!',
                                text: 'Anda tidak dibenarkan untuk melakukan tindakan ini!',
                                type: 'error'
                            });
                        });
                    },
                    deleteTarikh(id) {
                        swal({
                            title: 'Amaran!',
                            text: 'Anda pasti untuk menghapuskan rekod pengisytiharan puasa?',
                            type: 'warning',
                            cancelButtonText: 'Tidak',
                            showCancelButton: true,
                            confirmButtonText: 'Ya!',
                            showLoaderOnConfirm: true,
                            allowOutsideClick: () => !swal.isLoading(),
                            preConfirm: (email) => {
                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        method: "delete",
                                        url: base_url + "rpc/puasa/"+id,
                                        data: {tkhMula: this.tkhMula, tkhTamat: this.tkhTamat},                
                                        success: function(result) {
                                            console.log(result);
                                            resolve(result);
                                        },
                                        error: function(result) {
                                            reject(result);
                                        },
                                        statusCode: login()
                                    });
                                })
                            }
                        }).then((result) => {
                            if (result.value) {
                                this.senPuasa = this.senPuasa.filter(puasa => puasa.id != id);
                            }
                        }).catch(function () {
                            swal({
                                title: 'Ralat!',
                                text: 'Anda tidak dibenarkan untuk melakukan tindakan ini!',
                                type: 'error'
                            });
                        });
                    }
                },
                mounted () {
                    $('#tkhPuasaMula').datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoclose: true
                    }).on('changeDate', () => { this.tkhMula = $('#tkhPuasaMula').val() } )

                    $('#tkhPuasaTamat').datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoclose: true
                    }).on('changeDate', () => { this.tkhTamat = $('#tkhPuasaTamat').val() });
                },
                created () {    
                    $.ajax({
                        url: base_url + "rpc/puasa/",                
                        success: response => {
                            this.senPuasa = response.data.map((item)=> {
                                item.tkhmula = moment(item.tkhmula).format('DD-MM-YYYY');
                                item.tkhtamat = moment(item.tkhtamat).format('DD-MM-YYYY');
                                return item;
                            });
                        },
                        error: response => {
                            console.log(response);
                        }
                    });
                },
            });
        });
    </script>
@endsection