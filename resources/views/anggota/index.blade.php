@inject('Flow', 'App\Flow')

@extends('layouts.master')

@section('content')

    <section class="content-header">
        <h1>
        <i class="fa fa-user"></i></i> Pegawai
        <small>Menguruskan maklumat pegawai</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= route('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Maklumat Pegawai</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Start box -->
        <div id="grid-wrapper" class="box">
            <div class="box-body table-responsive">
                <div class="row" style="margin:0;">
                    <div class="col-lg-3">
                        <div id="panel-department" class="panel panel-default" >
                            <div class="panel-heading" style="background-image: linear-gradient(to bottom, #fafafa 0, #f4f4f4 100%;);">
                                <div><i class="fa fa-sitemap fa-fw"></i> Bahagian/Unit</div>
                                <div class="checkbox">
                                    <label>
                                        <input id="sub-dept" type="checkbox" checked> Sub Jabatan
                                    </label>
                                </div>
                            </div>
                            <div class="panel-body" style="overflow:auto;">
                                <div id="departments"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="pull-right" style="padding-bottom:5px;">
                            <table>
                                <tr>
                                    <td style="margin:0;padding:0;">
                                        <div class="input-group input-group-sm" style="width: 250px;">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                            <input id="search-key" type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                                        </div>
                                    </td>
                                    <td style="margin:0;padding:0;">
                                        &nbsp;<button id="top-btn-profil" class="btn btn-default btn-flat btn-sm" disabled><i class="fa fa-user"></i> Profil</button>
                                    </td>
                                    <td style="margin:0;padding:0;">
                                        &nbsp;<button id="top-btn-wp" class="btn btn-default btn-flat btn-sm" disabled><i class="fa fa-clock-o"></i> Waktu Bekerja</button>
                                    </td>
                                    <td style="margin:0;padding:0;">
                                        &nbsp;<button id="top-btn-ppp" class="btn btn-default btn-flat btn-sm" disabled><i class="fa fa-users"></i> Pegawai Penilai</button>
                                    </td>
                                    <td style="margin:0;padding:0;">
                                        <ul class="nav nav-pills">
                                            <li role="presentation" class="dropdown ">
                                                <botton id="top-btn-more" class="dropdown-toggle btn btn-link btn-sm disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;" disabled>
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </botton>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    @can('view-base-bahagian')
                                                    <li><a id="btn-base-bahagian" href="#"><i class="fa  fa-map-marker"></i> Base Bahagian</a></li>    
                                                    @endcan
                                                    <li><a id="btn-flow-profil" href="#"><i class="fa fa-random"></i> Flow</a></li>
                                                    <li><a id="btn-man-login" href="#"><i class="fa fa-key"></i> Login</a></li>
                                                    <!-- <li><a id="btn-arkib" href="#"><i class="fa fa-archive"></i> Arkib</a></li> -->
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="dg-anggota"></div>
                    </div>
                </div>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>

        <div id="detail-info-personal" class="box" style="display:none;">
            <div class="box-header with-border">
              <h3 id="back-wrapper" class="box-title">Back</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <div class="box-body">

            </div>
        </div>
        <!-- End box -->
    </section>
    <!-- /.content -->

    <!-- Modal --> 
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <h4>
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </h4>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal --> 
    <div class="modal fade" id="modal-wp">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body" style="background-color: #ecf0f5;">
                <h4>
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </h4>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal --> 
    <div class="modal fade" id="modal-ppp">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body" style="background-color: #ecf0f5;">
                <h4>
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </h4>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

        <!-- Modal --> 
    <div class="modal fade" id="modal-edit-ppp">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <form id="frm-ppp" method="post" role="form">
                    <input id="pegawai-flag" type="hidden" name="pegawai-flag">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div id="panel-department2" class="panel panel-default" >
                                <div class="panel-heading">
                                    <div><i class="fa fa-sitemap fa-fw"></i> Bahagian/Unit</div>
                                    <div class="checkbox">
                                        <label>
                                            <input id="sub-dept2" type="checkbox"> Sub Jabatan
                                        </label>
                                    </div>
                                </div>
                                <div class="panel-body" style="overflow:auto;">
                                    <div id="departments2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <select id="comSenPPP" class="form-control" size='20' name="comSenPPP"></select>
                            </div>
                        </div>
                    </div>
                    <button id="btn-ppp-batal" type="button" class="btn btn-link" style="color:#dd4b39;" title="Kemaskini maklumat pegawai penilai">BATAL</button>
                    <button id="btn-ppp-simpan" type="submit" class="btn btn-success" title="Kemaskini maklumat pegawai penilai">SIMPAN</button>
                </form>

            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal --> 
    <div class="modal fade" id="modal-peranan">
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <form id="frmTambahPeranan">
                <div class="modal-body">
                        <div id="ctxPeranan">
                            <h4>
                                <i class="fa fa-refresh fa-spin"></i> Loading...
                            </h4>
                        </div>
                        <div id="ctxJabatan"></div>
                    
                </div>
                <div class="modal-footer">
                    <?php //if (lib('lauthz')->minRole('kerani')) : ?>
                        <button class="btn btn-success pull-right btn-kemaskini-simpan" type="submit">OK</button>
                        <button id="btn-batal" type="button" class="btn btn-link pull-right" style="color:#dd4b39;" data-dismiss="modal" aria-label="Close" >BATAL</button>
                    <?php //endif ?>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal --> 
    <div class="modal fade" id="modal-edit-peranan">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <div id="ctxSubsPeranan" class="table-responsive">
                        <table id="tbl-desc-peranan" class="table table-bordered">
                            <tbody>
                                <form id="frmTambahJabatan">
                                <tr>
                                    <td>
                                        <div style="position: relative;">
                                            <input id="departmentDisplay3" class="form-control departmentDisplay" type="text" placeholder="Jabatan" style="background-color: #FFF;" readonly>
                                            <input id="departmentDisplayId3" name="txtDepartmentId" class="form-control departmentDisplayId" type="hidden" style="background-color: #FFF;" readonly>
                                            <div id="treeDisplay3" style="display:none;">
                                                <div id="departmentsTree3" style="position:absolute; background-color: #FFF; overflow:auto; max-height:200px; border:1px #ddd solid"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 1px">
                                        <button class="btn btn-default btn-flat btn-pcrs-tambah-jabatan" type="submit"><i class="fa fa-key"></i> Daftar</button>
                                    </td>
                                </tr>
                                </form>
                            </tbody>
                        </table>
                    </div>
                    <div id="ctxJabatan"></div>
                </div>
                <div class="modal-footer">
                    <button id="btn-batal" type="button" class="btn btn-link pull-right" style="color:#dd4b39;" data-dismiss="modal" aria-label="Close" >BATAL</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal --> 
    <div class="modal fade" id="modal-man-login">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <h4>
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </h4>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal --> 
    <div class="modal fade" id="modal-base-bahagian">
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <h4>
                    <i class="fa fa-refresh fa-spin"></i> Loading...
                </h4>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

        <!-- Modal --> 
    <div class="modal fade" id="modal-flow-profil">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
            </div>
            <div class="modal-body">
                <div id="loading" >
                    <h4>
                        <i class="fa fa-refresh fa-spin"></i> Loading...
                    </h4>
                </div>
                <div id="konfigurasi" style="display: none;">
                   <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td style="width: 40%">
                                    <b>Flow Kelulusan Bahagian/ Unit</b>
                                    <p class="help-block">
                                        Memastikan flow kelulusan mengikut keperluan bahagian atau unit.
                                        <ul class="list-unstyled">
                                            <li>'<b>BIASA</b>' adalah flow mengikut Penilai Pertama. (*)</li>
                                            <li>'<b>KETUA</b>' adalah flow semua permohonan diluluskan oleh Ketua Bahagian/ Unit.</li>
                                        </ul>
                                        
                                    </p>
                                </td>
                                <td style="width: 60%">
                                    NILAI: <span id="info-flow-bahagian">LALAA</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%">
                                    <b>Flow Kelulusan Profil</b>
                                    <p class="help-block">
                                        Memastikan flow kelulusan mengikut keperluan bahagian atau unit.
                                        <ul class="list-unstyled">
                                            <li>'<b>INHERIT</b>' adalah flow mengikut Konfigurasi Bahagian/ Unit. (*)</li>
                                            <li>'<b>BIASA</b>' adalah flow mengikut Penilai Pertama.</li>
                                            <li>'<b>KETUA</b>' adalah flow semua permohonan diluluskan oleh Ketua Bahagian/ Unit.</li>
                                        </ul>
                                        
                                    </p>
                                </td>
                                <td style="width: 60%">
                                   NILAI: <span id="info-flow-profil"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


@endsection

@section('scripts')

<script>

    $(function() {
        var dataSearch = {
            searchKey: '',
            searchDept: 1,
            subDept: true
        };

        var dataSearch2 = {
            searchKey: '',
            searchDept: 1,
            subDept: false
        };

        var mProfil = {
            title: '',
            userId: '',
            operasi: '',
            deptId: '',
            deptName: ''
        };

        var departments = '';
        var url = base_url+'rpc/anggota_grid';
        var userSubsPeranan = [];
        var subsPeranan = '';
        var penilai = {};
        var userRow = {};

        populateDept('#panel-department', '#departments', url, '#dg-anggota', '.content-wrapper');
        populateDg(url, '#dg-anggota');

        function populateDept(panelEl, selectEl, dgUrl, dgPlaceholder, content)
        {
            $.ajax({
                url: base_url+'rpc/department_tree',
                dataType: 'json',
                success: function( result, textStatus, jqXHR ) {
                    departments = result;
                    
                    $(selectEl).on('select_node.jstree', function (e, data) {
                        $('#top-btn-profil').prop('disabled', true);
                        $('#top-btn-wp').prop('disabled', true);
                        $('#top-btn-ppp').prop('disabled', true);
                        $('#top-btn-more').addClass('disabled');
                        $('#top-btn-more').prop('disabled', true);

                        dataSearch.searchDept = data.instance.get_node(data.selected[0]).id;
                        populateDg(dgUrl, dgPlaceholder);
                    }).jstree({
                        core:{
                            data: departments
                        }
                    });

                    if(content === undefined) {
                        var actualHeight = 300;
                        $(panelEl).find('.panel-body').css('height', actualHeight);
                    }
                    else {
                        var actualHeight = $(content).actual('height');
                        $(panelEl).find('.panel-body').css('height', actualHeight-300);
                    }
                }
            });
        }
        
        function populateDept2(panelEl, selectEl, dgUrl, dgPlaceholder, content)
        {
            $.ajax({
                url: base_url+'rpc/department_tree',
                dataType: 'json',
                success: function( result, textStatus, jqXHR ) {
                    departments = result;
                    
                    $(selectEl).on('select_node.jstree', function (e, data) {
                        dataSearch2.searchDept = data.instance.get_node(data.selected[0]).id;
                        populateDg2(dgUrl, dgPlaceholder, dataSearch2);
                    }).jstree({
                        core:{
                            data: departments
                        }
                    });

                    if(content === undefined) {
                        var actualHeight = 300;
                        $(panelEl).find('.panel-body').css('height', actualHeight);
                    }
                    else {
                        var actualHeight = $(content).actual('height');
                        $(panelEl).find('.panel-body').css('height', actualHeight-300);
                    }
                    
                    dataSearch2.searchDept = mProfil.deptId;
                    dataSearch2.subDept = false;
                    populateDg2(dgUrl, dgPlaceholder, dataSearch2);
                }
            });
        }

        function populateDg(url, place) {
            $('.overlay').show();
            $.ajax({
                method: 'post',
                url: url,
                data: dataSearch,
                success: function(data, textStatus, jqXHR) {
                    $(place).html(data);
                    $('.overlay').hide();

                    if(dataSearch.searchKey) {
                        
                        $(".table tbody tr").unmark({
                            done: function() {
                                $(".table tbody tr").mark(dataSearch.searchKey,{debug: true});
                            }
                        });
                    }

                    $("#search-key").addClear({
                        onClear: function(e){
                            $('#top-btn-profil').prop('disabled', true);
                            $('#top-btn-wp').prop('disabled', true);
                            $('#top-btn-ppp').prop('disabled', true);
                            $('#top-btn-more').prop('disabled', true);
                            $('#top-btn-more').addClass('disabled');

                            dataSearch.searchKey = '';
                            populateDg(base_url+'rpc/anggota_grid', '#dg-anggota');
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: 'Ralat!',
                        text: 'Data tidak dapat dipaprkan. Sila cub lagi',
                        type: 'error',
                    }).then(() => $('#modal-default').modal('hide'));
                },
                statusCode: login()
            });
        }

        function populateDg2(url, place, dataSearch) {
            var options = $("#comSenPPP");
            options.children().remove();
            options.append(new Option('Loading...', 0));

            $.ajax({
                method: 'post',
                url: url,
                data: dataSearch,
                success: function(data, textStatus, jqXHR) {
                    options.children().remove();

                    $.each(data.data, function(key, val) {
                        options.append(new Option(val.nama+' ('+val.jawatan+')', val.anggota_id, false, (penilai.id === val.anggota_id ? true : false)));
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {

                },
                statusCode: login()
            });
        }

        $('#dg-anggota').on('click', '.btn-page', function(e) {
            e.preventDefault();
            $('#top-btn-profil').prop('disabled', true);
            $('#top-btn-wp').prop('disabled', true);
            $('#top-btn-ppp').prop('disabled', true);
            $('#top-btn-more').prop('disabled', true);
            $('#top-btn-more').addClass('disabled');

            url = $(this).attr('href');
            populateDg(url, '#dg-anggota');
        });

        $('#search-key').on('keydown', function(e) {
            if(e.which === 13) {
                $('#top-btn-profil').prop('disabled', true);
                $('#top-btn-wp').prop('disabled', true);
                $('#top-btn-ppp').prop('disabled', true);
                $('#top-btn-more').prop('disabled', true);
                $('#top-btn-more').addClass('disabled');

                if (e.target.value) {
                    dataSearch.searchKey = e.target.value;
                    populateDg(base_url+'rpc/anggota_grid', '#dg-anggota');
                }
            }
        })

        $('#sub-dept').on('click', function(e) {
            $('#top-btn-profil').prop('disabled', true);
            $('#top-btn-wp').prop('disabled', true);
            $('#top-btn-ppp').prop('disabled', true);
            $('#top-btn-more').prop('disabled', true);
            $('#top-btn-more').addClass('disabled');

            dataSearch.subDept = $(this).is(':checked');
            populateDg(base_url+'rpc/anggota_grid', '#dg-anggota');
        });

        $('#dg-anggota').on('click', '.btn-profil', function(e) {
            e.preventDefault();
            mProfil.title = $(this).data('nama');
            mProfil.userId = $(this).data('userid');
            mProfil.operasi = 'papar';
            $('#modal-default').modal('show');
        });

        $('#dg-anggota').on('click', '.btn-wp', function(e) {
            e.preventDefault();
            mProfil.title = $(this).data('nama');
            mProfil.userId = $(this).data('userid');
            mProfil.operasi = 'papar';
            $('#modal-wp').modal('show');
        });

        $('#dg-anggota').on('click', '.btn-ppp', function(e) {
            e.preventDefault();
            mProfil.title = $(this).data('nama');
            mProfil.userId = $(this).data('userid');
            mProfil.deptId = $(this).data('deptid');
            mProfil.operasi = 'papar';
            $('#modal-ppp').modal('show');
        });

        $('#top-btn-profil').on('click', function(e) {
            e.preventDefault();
            mProfil.operasi = 'kemaskini';
            $('#modal-default').modal('show');
        });

        $('#top-btn-wp').on('click', function(e) {
            e.preventDefault();
            mProfil.operasi = 'papar';
            $('#modal-wp').modal('show');
        });

        $('#top-btn-ppp').on('click', function(e) {
            e.preventDefault();
            mProfil.operasi = 'papar';
            $('#modal-ppp').modal('show');
        });

        $('#modal-default').on('click', '.btn-kemaskini', function(e) {
            e.preventDefault();
            $('#modal-default').modal('hide');
            mProfil.title = $(this).data('nama');
            mProfil.userId = $(this).data('userid');
            mProfil.operasi = 'kemaskini';
        });

        $('#modal-default').on('submit', '#frm-profil-kemaskini', function(e) {

            e.preventDefault();
            
            var user_id = mProfil.userId;
            var formData = new FormData(this);

            swal({
                title: 'Amaran!',
                text: 'Anda pasti untuk mengemaskini maklumat ini?',
                type: 'warning',
                cancelButtonText: 'Tidak',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !swal.isLoading(),
                preConfirm: (email) => {
                    return new Promise((resolve,reject) => {
                         $.ajax({
                            method: 'post',
                            data: formData,
                            cache       : false,
                            contentType : false,
                            processData : false,
                            url: base_url+'rpc/anggota/'+user_id,
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
                    });

                    populateDg(url,'#dg-anggota');
                    $('#modal-default').modal('hide');
                }
            }).catch(function (error) {
                swal({
                    title: 'Ralat!',
                    text: 'Pengemaskinian tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                });
            });
        });
        
        $('#modal-default').on('click', '#departmentDisplay', function(e) {
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

        $('#modal-default').on('show.bs.modal', function (e) {
            $(this).find('.modal-header').css('backgroundColor','steelblue');
            $(this).find('.modal-header').css('color','white');
            $(this).find('.modal-title').text('PROFIL : '+mProfil.title);

            switch(mProfil.operasi) {
                case 'papar':
                    getProfil($(this).find('.modal-body'))
                    break;
                case 'kemaskini':
                    $(this).find('.modal-title').text('KEMASKINI PROFIL : '+mProfil.title);
                    mProfil.operasi = '';
                    getProfilEdit($(this).find('.modal-body'));
                    break;
            }
            
            function getProfil($placeholder)
            {
                $.ajax({
                    url: base_url+'rpc/anggota/'+mProfil.userId,
                    success: function(data, textStatus, jqXHR) {
                        $placeholder.html(data);
                    },
                    statusCode: login()
                    
                });
            }

            function getProfilEdit($placeholder)
            {
                departments[0].state.selected=false;
                $.ajax({
                    url: base_url+'rpc/anggota/'+mProfil.userId,
                    success: function(data, textStatus, jqXHR) {
                        $placeholder.html(data);

                        $('#departmentsTree').jstree({
                            core:{
                                multiple : false,
                                check_callback: true,
                                data: departments
                            }
                        });
                        
                        $('#departmentsTree').on('select_node.jstree', function (e, data) {
                            var id = data.instance.get_node(data.selected[0]).id;
                            var text = data.instance.get_node(data.selected[0]).text;

                            $('.departmentDisplay').val(text);
                            $('.departmentDisplayId').val(id);
                            $("#treeDisplay").hide();
                        });
                    },
                    statusCode: login()
                });
            }
        })

        $('#modal-default').on('hidden.bs.modal', function(e) {
            e.preventDefault();
            $(this).find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');

            switch(mProfil.operasi) {
                case 'kemaskini':
                    $(this).modal('show');
                break;
            }
        })

        $('#modal-default').on('click', '#btn-batal', function(e){
            e.preventDefault();
            $('#modal-default').modal('hide');
        });

        $('#modal-wp').on('show.bs.modal', function (e) {
            $(this).find('.modal-header').css('backgroundColor','steelblue');
            $(this).find('.modal-header').css('color','white');
            $(this).find('.modal-title').text('WAKTU BERPERINGKAT : '+mProfil.title);
            
            switch(mProfil.operasi) {
                case 'papar':
                    getWp($(this).find('.modal-body'))
                    break;
            }

            function getWp(placeholder) {
                $.ajax({
                    url: base_url+'rpc/anggota/waktu_bekerja/'+mProfil.userId,
                    success: function(data, textStatus, jqXHR) {
                        placeholder.html(data);

                        var mula = $('#txtTarikhMula');
                        var tamat = $('#txtTarikhTamat');

                        mula.datepicker({
                            format: 'yyyy-mm-dd',
                            todayHighlight: true,
                            autoclose: true
                        })
                        .on('changeDate', function(e) {
                            tamat.datepicker('setDate','');
                            tamat.datepicker('setStartDate',$(this).val());
                        })
                        .on('show', function(e) {
                            e.stopPropagation(); 
                        });

                        tamat.datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true
                        })
                        .on('show', function(e) {
                            e.stopPropagation(); 
                        });

                        $('#frmWbbBulanan').on('submit', function(e) {
                            e.preventDefault();
                            var formData = new FormData(this);
                            var formEl = $(this);
                            
                            swal({
                                title: 'Amaran!',
                                text: 'Anda pasti untuk menambah maklumat ini?',
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
                                            data: formData,
                                            cache       : false,
                                            contentType : false,
                                            processData : false,
                                            url: base_url+'rpc/anggota/waktu_bekerja_bulanan/'+mProfil.userId,
                                            success: function() {
                                                resolve();
                                            },
                                            error: function(err) {
                                                reject();
                                            },
                                            statusCode: login()
                                        });
                                    })
                                }
                            }).then((result) => {
                                if (result.value) {
                                    swal({
                                        title: 'Berjaya!',
                                        text: 'Maklumat telah ditambah',
                                        type: 'success'
                                    });
                                    formEl.trigger('reset');
                                    loadWbbBulanan($('#jadualWbbBulanan'));
                                    loadWbbHarian($('#jadualWbbHarian'));
                                }
                            }).catch(function (error) {
                                swal({
                                    title: 'Ralat!',
                                    text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                                    type: 'error'
                                });
                            });
                        });

                        $('#frmWbbHarian').on('submit', function(e) {
                            e.preventDefault();
                            var formData = new FormData(this);
                            var formEl = $(this);
                            
                            swal({
                                title: 'Amaran!',
                                text: 'Anda pasti untuk menambah maklumat ini?',
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
                                            data: formData,
                                            cache       : false,
                                            contentType : false,
                                            processData : false,
                                            url: base_url+'rpc/anggota/waktu_bekerja_harian/'+mProfil.userId,
                                            success: function() {
                                                resolve();
                                            },
                                            error: function(err) {
                                                reject(err);
                                            },
                                            statusCode: login()
                                        });
                                    })
                                }
                            }).then((result) => {
                                if (result.value) {
                                    swal({
                                        title: 'Berjaya!',
                                        text: 'Maklumat telah ditambah',
                                        type: 'success'
                                    });
                                    formEl.trigger('reset');
                                    loadWbbBulanan($('#jadualWbbBulanan'));
                                    loadWbbHarian($('#jadualWbbHarian'));
                                }
                            }).catch(function (error) {
                                var errorMsg = error.statusText;

                                if (error.status == 409) {
                                    errorMsg = 'Rekod Waktu Bekerja telah wujud!';
                                }

                                swal({
                                    title: 'Ralat!',
                                    text: errorMsg,
                                    type: 'error'
                                });
                            });
                        });

                        loadWbbBulanan($('#jadualWbbBulanan'));
                        loadWbbHarian($('#jadualWbbHarian'));                        
                    },
                    statusCode: login()
                });
            }
        });
        
        $('#modal-wp').on('hidden.bs.modal', function(e) {
            e.preventDefault();
            $(this).find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
        })

        $('#modal-ppp').on('show.bs.modal', function (e) {
            $(this).find('.modal-header').css('backgroundColor','steelblue');
            $(this).find('.modal-header').css('color','white');
            $(this).find('.modal-title').text('PEGAWAI PENILAI : '+mProfil.title);

            var modalBody = $(this).find('.modal-body');
            
            $.ajax({
                url: base_url+'rpc/anggota/'+mProfil.userId+'/penilai',
                success: function(data, textStatus, jqXHR) {
                    modalBody.html(data);
                }
            });
        });

        $('#modal-ppp').on('hidden.bs.modal', function(e) {
            e.preventDefault();
            $(this).find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
        })

        $('#modal-ppp').on('click', '#btn-ppp-edit', function(e){
            $('#pilih-ppp-panel').slideDown('easing');
            $('#pilih-ppp-simpan-panel').show();
            $(this).hide();
        });

        $('#modal-edit-ppp').on('click', '#btn-ppp-batal', function(e){
            $('#modal-edit-ppp').modal('hide');
        });

        $('#modal-ppp').on('submit', '#frm-ppp', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var formEl = $(this);
            
            swal({
                title: 'Amaran!',
                text: 'Anda pasti untuk mengemaskini maklumat ini?',
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
                            data: formData,
                            cache       : false,
                            contentType : false,
                            processData : false,
                            url: base_url+'rpc/anggota/'+mProfil.userId+'/penilai',
                            success: function() {
                                resolve();
                            },
                            error: function(err) {
                                reject();
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
                    }).then(() => $('#modal-ppp').modal('hide'));
                }
            }).catch(function (error) {
                swal({
                    title: 'Ralat!',
                    text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                });
            });
        });

        $('#modal-ppp').on('click', '.btn-ppp-edit', function(e) {
            var header = $('#modal-edit-ppp').find('.modal-title');
            var pegawaiFlag = $(this).data('pegawai_flag');
            penilai.id = $(this).data('pegawai_id');
            penilai.flag = pegawaiFlag;

            $('#modal-edit-ppp').find('.modal-header').css('backgroundColor','steelblue');
            $('#modal-edit-ppp').find('.modal-header').css('color','white');

            if (pegawaiFlag == {{ \App\PegawaiPenilai::FLAG_PEGAWAI_PERTAMA }})
                header.text('PEGAWAI PENILAI PERTAMA');

            if (pegawaiFlag == {{ \App\PegawaiPenilai::FLAG_PEGAWAI_KEDUA }})
                header.text('PEGAWAI PENILAI KEDUA');

            $('#pegawai-flag').val(pegawaiFlag);

            $('#modal-edit-ppp').modal({backdrop: 'static', keyboard: false});
        });

        function loadWbbBulanan(placeholder) {
            var dataBulanan = '';
            var parentDom = placeholder;

            $.ajax({
                url: base_url+'rpc/anggota/waktu_bekerja_bulanan/'+mProfil.userId+'/'+$('#comTahun').val(),
                success: function(data, textStatus, jqXHR) {
                    dataBulanan = data;
                    janaJadual(placeholder, dataBulanan);
                },
                statusCode: login()
            });

            parentDom.on('click', '.btn-hapus-wbb', function(e){
                e.preventDefault();

                var waktuBekerjaId = $(this).data('waktu_bekerja_id');
                var bulan = $(this).data('bulan');
                var tahun = $(this).data('tahun');

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
                                url: base_url+'rpc/anggota/waktu_bekerja_bulanan/'+mProfil.userId+'/'+waktuBekerjaId,                
                                success: function() {
                                    swal({
                                        title: 'Berjaya!',
                                        text: 'Maklumat telah dihapuskan!',
                                        type: 'success'
                                    });
                                    
                                    _.remove(dataBulanan.data, {'MONTH': bulan, 'YEAR': tahun});
                                    janaJadual(placeholder, dataBulanan);
                                    janaJadualHarian($('#jadualWbbHarian'), dataBulanan);
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
        }

        function loadWbbHarian(placeholder) {

            var dataBulanan = '';
            var parentDom = placeholder;

            $.ajax({
                url: base_url+'rpc/anggota/waktu_bekerja_harian/'+mProfil.userId+'/'+$('#comTahun').val(),
                success: function(data, textStatus, jqXHR) {
                    dataBulanan = data;
                    janaJadualHarian(placeholder, dataBulanan);
                },
                statusCode: login()
            });

            parentDom.on('click', '.btn-hapus-wbb', function(e){
                e.preventDefault();

                var waktuBekerjaId = $(this).data('waktu_bekerja_id');
                var tkhMula = $(this).data('tkhmula');
                var tkhTamat = $(this).data('tkhtamat');

                swal({
                    title: 'Amaran!',
                    text: 'Anda pasti untuk menghapuskan maklumat ini?',
                    type: 'warning',
                    cancelButtonText: 'Tidak',
                    showCancelButton: true,
                    confirmButtonText: 'Ya!',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !swal.isLoading(),
                    preConfirm: (email) => {
                        return new Promise((resolve, reject) => {
                            $.ajax({
                                method: 'post',
                                data: {'_method': 'DELETE'},
                                url: base_url+'rpc/anggota/waktu_bekerja_harian/'+mProfil.userId+'/'+waktuBekerjaId,             
                                success: function() {
                                    swal({
                                        title: 'Berjaya!',
                                        text: 'Maklumat telah dihapuskan!',
                                        type: 'success'
                                    });

                                    _.remove(dataBulanan.data, {'STARTDATE': tkhMula, 'ENDDATE': tkhTamat});
                                    janaJadualHarian(placeholder, dataBulanan);
                                    janaJadual($('#jadualWbbBulanan'), dataBulanan);
                                },
                                error: function() {
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
        }

        function janaJadual(container, data) {
            var table = $("<table/>").addClass('table table-bordered table-hover');

            table.append($('<thead/><tr style="background-color: #f5f5f5;"><th>BULAN</th><th>WB</th><th style="width:1px;">OPERASI</th></tr>'));
            table = table.append($('<tbody/>'));

            $.each(data.data, function(rowIndex, r) {
                var row = $("<tr/>");

                if(r.MONTH == moment().month()+1) {
                    row.css('backgroundColor', '#f5f5dd');
                }

                row.append($("<td/>").text(bulan[(parseInt(r.MONTH)).toString()].toUpperCase()));
                row.append($("<td/>").text(r.NAME));
                row.append($("<td/>").html('<a title="Hapus rekod wbb" class="btn btn-danger btn-xs btn-hapus-wbb" data-waktu_bekerja_id="'+r.NUM_RUNID+'" data-bulan="'+r.MONTH+'" data-tahun="'+r.YEAR+'" href="#" style="margin: auto; display: block;"><i class="fa fa-trash-o"></i></a>'));

                table.append(row);
            });
            return container.html(table);
        }

        function janaJadualHarian(container, data) {
            var table = $("<table/>").addClass('table table-bordered table-hover');

            table.append($('<thead/><tr style="background-color: #f5f5f5;"><th>MULA</th><th>TAMAT</th><th>WB</th><th style="width:1px;">OPERASI</th></tr>'));
            table = table.append($('<tbody/>'));

            $.each(data.data, function(rowIndex, r) {
                var row = $("<tr/>");

                if(r.MONTH == (new Date()).getMonth() + 1) {
                    row.css('backgroundColor', '#f5f5dd');
                }

                row.append($("<td/>").text(moment(r.STARTDATE).format('DD MMM YYYY')));
                row.append($("<td/>").text(moment(r.ENDDATE).format('DD MMM YYYY')));
                row.append($("<td/>").text(r.NAME));
                row.append($("<td/>").html('<a title="Hapus rekod wbb" class="btn btn-danger btn-xs btn-hapus-wbb" data-waktu_bekerja_id="'+r.NUM_RUNID+'" data-tkhmula="'+r.STARTDATE+'" data-tkhtamat="'+r.ENDDATE+'" href="#" style="margin: auto; display: block;"><i class="fa fa-trash-o"></i></a>'));

                table.append(row);
            });

            return container.html(table);
        }

        $('#dg-anggota').on('click', '.row-user', function(e) {
            var rows = $('#dg-anggota .row-user');
            userRow = $(this);

            Object.values(rows).forEach(function(row)
            {
                $(row).removeAttr('style');
            });

            mProfil.title = $(this).data('nama');
            mProfil.userId = $(this).data('userid');
            mProfil.deptId = $(this).data('deptid');
            mProfil.deptName = $(this).data('deptname');
            
            $(this).css('background-color', '#c2eafe');

            $('#top-btn-profil').prop('disabled', false);
            $('#top-btn-wp').prop('disabled', false);
            $('#top-btn-ppp').prop('disabled', false);
            $('#top-btn-more').prop('disabled', false);
            $('#top-btn-more').removeClass('disabled');
            $('#top-btn-more').removeAttr('disabled');
        });

        $('#btn-man-login').on('click', function(e){
            e.preventDefault();
            $('#modal-man-login').modal('show');
        });

        $('#modal-man-login').on('show.bs.modal', function (e) {
            $(this).find('.modal-header').css('backgroundColor','steelblue');
            $(this).find('.modal-header').css('color','white');
            $(this).find('.modal-title').text('MAKLUMAT LOGIN : '+mProfil.title);

            var modalBody = $(this).find('.modal-body');
            
            $.ajax({
                url: base_url+'rpc/pengguna/'+mProfil.userId+'/login',
                success: function(data, textStatus, jqXHR) {
                    modalBody.html(data);

                    $('#departmentsTree').on('select_node.jstree', function (e, data) {
                        var id = data.instance.get_node(data.selected[0]).id;
                        var text = data.instance.get_node(data.selected[0]).text;

                        $('.departmentDisplay').val(text);
                        $('.departmentDisplayId').val(id);
                        $("#treeDisplay").hide();
                    }).jstree({
                        core:{
                            multiple : false,
                            check_callback: true,
                            data: departments
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 404)
                    {
                        modalBody.html(jqXHR.responseText);
                    }
                },
                complete: function() {
                    $('.internal').hide();
                    $('.external').hide();
                }
            });
        });

        $('#modal-man-login').on('submit', '#frm-add-peranan', function(e) {
            e.preventDefault();
            
            var modalBody = $('#modal-man-login').find('.modal-body');
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
                            method: 'POST',
                            data: formData,
                            cache       : false,
                            contentType : false,
                            processData : false,
                            url: base_url+'rpc/pengguna/'+mProfil.userId+'/peranan',
                            success: function(data, extStatus, jqXHR) {
                                resolve({value: true});
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                reject(textStatus);
                            },
                            statusCode: login()
                        });
                    });
                }
            }).then((result) => {
                if (result.value) {
                    swal({
                        title: 'Berjaya!',
                        text: 'Maklumat telah disimpan',
                        type: 'success'
                    });

                    $.ajax({
                        url: base_url+'rpc/pengguna/'+mProfil.userId+'/login',
                        success: function(data, textStatus, jqXHR) {
                            modalBody.html(data);

                            $('#departmentsTree').on('select_node.jstree', function (e, data) {
                                var id = data.instance.get_node(data.selected[0]).id;
                                var text = data.instance.get_node(data.selected[0]).text;

                                $('.departmentDisplay').val(text);
                                $('.departmentDisplayId').val(id);
                                $("#treeDisplay").hide();
                            }).jstree({
                                core:{
                                    multiple : false,
                                    check_callback: true,
                                    data: departments
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(jqXHR.status == 404)
                            {
                                modalBody.html(jqXHR.responseText);
                            }
                        },
                        complete: function() {
                            $('.internal').hide();
                            $('.external').hide();
                        }
                    });
                }
            }).catch(function (error) {

                console.log(error);
                swal({
                    title: 'Ralat!',
                    text: 'Operasi tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                });
            });
        });

        $('#modal-man-login').on('click', '#departmentDisplay', function(e) {
            e.preventDefault();
            var jsTreeInstance = $('#departmentsTree').jstree(true);
            var currentDeptID = $('#departmentDisplayId').val().toString();

            $('#departmentsTree').css('width', $(this).parent().actual('width'));
            jsTreeInstance.deselect_all();
            jsTreeInstance.select_node(currentDeptID);
            $('#treeDisplay').toggle();

            $(document).click(function (e) {
                if (!$(e.target).hasClass("departmentDisplay") 
                    && $(e.target).parents("#treeDisplay").length === 0) 
                {
                    $("#treeDisplay").hide();
                }
            });
        });

        $('#modal-man-login').on('click', '.rdoDomain', function(e){
            var domain = $(this).val();

            if(domain == 'internal')
            {
                $('.internal').show();
                $('.external').hide();

                $('#txtEmail').prop('required', true);
                $('#txtKatalaluan').prop('required', true);
                $('#txtReKatalaluan').prop('required', true);
                return;
            }

            $('.internal').hide();
            $('.external').show();

            $('#txtEmail').prop('required', false);
            $('#txtKatalaluan').prop('required', false);
            $('#txtReKatalaluan').prop('required', false);
        });

        $('#modal-man-login').on('click', '#btn-batal', function(e){
            e.preventDefault();
            $('#modal-man-login').modal('hide');
        });

        $('#modal-man-login').on('submit', '#frm-create-login', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var modalBody = $('#modal-man-login').find('.modal-body');

            swal({
                title: 'Amaran!',
                text: 'Anda pasti untuk meneruskan operasi ini?',
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
                            data: formData,
                            cache       : false,
                            contentType : false,
                            processData : false,
                            url: base_url+'rpc/pengguna/'+mProfil.userId+'/login',
                            success: function(resp, textStatus, jqXHR) {
                                resolve(resp);
                            },
                            error: function(err) {
                                reject();
                            },
                            statusCode: login()
                        });
                    })
                }
            }).then((result) => {
                if (result) {
                    swal({
                        title: 'Berjaya!',
                        text: 'Pengguna telah dipadankan dengan identiti berkaitan',
                        type: 'success'
                    });

                    userRow.find('td').eq(1).html('<i title="Login" class="fa"><img src="' + base_url + '/images/icons/icon_key.gif"></i>');
                    modalBody.html(result.value);

                    $('#departmentsTree').on('select_node.jstree', function (e, data) {
                        var id = data.instance.get_node(data.selected[0]).id;
                        var text = data.instance.get_node(data.selected[0]).text;

                        $('.departmentDisplay').val(text);
                        $('.departmentDisplayId').val(id);
                        $("#treeDisplay").hide();
                    }).jstree({
                        core:{
                            multiple : false,
                            check_callback: true,
                            data: departments
                        }
                    });
                }
            }).catch(function (error) {
                swal({
                    title: 'Ralat!',
                    text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                });
            });
        });

        $('#modal-man-login').on('click', '#btn-external-pam', function(e){
            e.preventDefault();

            var nama = $('#txt-external-pam').val();

            $.ajax({
                method: 'post',
                url: base_url + 'rpc/pengguna/ldap',
                data: {'txt-external-pam': nama},
                success: function(data, textStatus, jqXHR) {
                    var t = $('#tbl-user-ldap');
                    var tr = '';

                    t.find('tbody').children().remove();

                    data.data.forEach(function(row) {
                        tr = $('<tr/>');
                        tr.append($("<td class=\"col-xs-1\"/>").html('<label style=\"margin: 0;\"><input style=\"margin: 0;\" class=\"opt-user\" type=\"radio\" name=\"opt-user\" value=\"'+row.username+'\"></label>'));
                        tr.append($("<td class=\"col-xs-2\"/>").text(row.username));
                        tr.append($("<td class=\"col-xs-5\"/>").text(row.cn));
                        tr.append($("<td class=\"col-xs-4\"/>").html(row.email));
                        t.append(tr);
                    });
                },
            });
        });

        $('#modal-man-login').on('click', '.btn-pcrs-tambah-peranan', function(e){
            $('#modal-peranan').modal('show');
        });

        $('#modal-man-login').on('click', '.btn-pcrs-edit-peranan', function(e){
            $('#modal-edit-peranan').modal('show');
        });

        $('#modal-man-login').on('hidden.bs.modal', function(e) {
            e.preventDefault();
            $(this).find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
        });
        
        $('#modal-man-login').on('click', '.pcrs-row-peranan-subscribe', function(e) {
            e.preventDefault();
            
            var rows = $('.pcrs-row-peranan-subscribe');
            subsPeranan = $(this).attr('data_id');
            
            Object.values(rows).forEach(function(row)
            {
                $(row).removeAttr('style');
            });

            $(this).css('background-color', '#c2eafe');

            if(parseInt($(this).find('td:nth-child(2)').text()) == 'PENGGUNA') {
                $('.btn-pcrs-edit-peranan').prop('disabled', true);
                $('.btn-pcrs-hapus-peranan').prop('disabled', true);

                return;
            }

            $('.btn-pcrs-edit-peranan').prop('disabled', false);
            $('.btn-pcrs-hapus-peranan').prop('disabled', false);
        });

        $('#modal-peranan').on('show.bs.modal', function (e) {
            $(this).find('.modal-header').css('backgroundColor','#99CC00');
            $(this).find('.modal-header').css('color','white');
            $(this).find('.modal-title').text('SENARAI PERANAN');
            
            var modalBody = $(this).find('.modal-body');
            var subsPeranan = $('#pcrs-tbl-peranan tbody tr td:nth-child(2)');
            
            userSubsPeranan = [];
            subsPeranan.each(function(){
                userSubsPeranan.push(parseInt($(this).text()));
            });
            
            $.ajax({
                url: base_url + 'api/unsubs_senarai_peranan',
                method: 'post',
                data: {'subsperanan': userSubsPeranan},
                success: function(data, textStatus, jqXHR) {
                    var _table = $('<table class="table table-bordered" style="margin: 0;" />');
                    var _tbody = $('<tbody/>');

                    _.forEach(data, function(value) {
                        var tr = $('<tr/>');
                        tr.append('<td style="width:1px"><input type="radio" class="chkPeranan" name="chkPeranan" value="'+value[0]+'" data-desc="'+value[1]+'" required></td>');
                        tr.append('<td>'+value[1]+'</td>');
                        _tbody.append(tr);
                        _table.append(_tbody);
                    });
                    
                    modalBody.find('#ctxPeranan').html(_table);

                    $(_table).find('.chkPeranan').on('click', function(e) {
                        var chkPeranan = $(this).val();
                        var chkPerananDesc = $(this).data('desc');
                        var infoJabatan = '';

                        if(chkPeranan == 2 || chkPeranan == 3 || chkPeranan == 4) {
                            infoJabatan = $('<table class="table table-bordered" style="margin: 0;" />');
                            var _header = $('<thead><tr style="background-color: #f5f5f5;"><th>Jabatan diberi kebenaran : '+chkPerananDesc+'</th></tr></thead>');
                            var _body = $('<tbody><tr><td><div style="position: relative;"><input id="departmentDisplay2" class="form-control departmentDisplay" type="text" value="'+mProfil.deptName+'" style="background-color: #FFF;" readonly><input id="departmentDisplayId2" name="txtDepartmentId" class="form-control departmentDisplayId" type="hidden" value="'+mProfil.deptId+'" style="background-color: #FFF;" readonly><div id="treeDisplay2" style="display:none;"><div id="departmentsTree2" style="position:absolute; background-color: #FFF; overflow:auto; max-height:200px; border:1px #ddd solid"></div></div></div></td></tr></tbody>');
                            
                            infoJabatan.append(_header);
                            infoJabatan.append(_body);

                            modalBody.find('#ctxJabatan').html(infoJabatan);
                            departments[0].state.selected=false;
                            
                            $('#departmentsTree2').jstree({
                                core: {
                                    multiple : false,
                                    check_callback: true,
                                    data: departments
                                }
                            });
                            
                            $('#departmentsTree2').on('select_node.jstree', function (e, data) {
                                var id = data.instance.get_node(data.selected[0]).id;
                                var text = data.instance.get_node(data.selected[0]).text;

                                $('#departmentDisplay2').val(text);
                                $('#departmentDisplayId2').val(id);
                                $("#treeDisplay2").hide();
                            });
                        }
                        else {
                            modalBody.find('#ctxJabatan').html(infoJabatan);
                        }   
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 404) {
                        modalBody.html(jqXHR.responseText);
                    }
                }
            });
        });
        
        $('#modal-peranan').on('click', '#departmentDisplay2', function(e) {
            e.preventDefault();
            $('#departmentsTree2').css('width', $(this).parent().actual('width'));
            $('#departmentsTree2').jstree('select_node', $('#departmentDisplayId2').val().toString());
            $('#treeDisplay2').toggle();

            $(document).click(function (e) {
                if (! $(e.target).hasClass("departmentDisplay") && $(e.target).parents("#treeDisplay2").length === 0) {
                    $("#treeDisplay2").hide();
                }
            });
        });

        $('#modal-peranan').on('submit', '#frmTambahPeranan', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var formEl = $(this);
                        
            swal({
                title: 'Amaran!',
                text: 'Anda pasti untuk menambah peranan ini?',
                type: 'warning',
                cancelButtonText: 'Tidak',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                allowOutsideClick: () => ! swal.isLoading(),
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            method: 'post',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            url: base_url + 'api/subs_peranan/' + mProfil.userId,
                            success: function(data, extStatus, jqXHR) {
                                resolve(data);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                reject();
                            },
                            statusCode: login()
                        }); 
                    })
                }
            }).then((result) => {
                var senSubsPeranan = result.value;
                console.log(senSubsPeranan);

                swal({
                    title: 'Berjaya!',
                    text: 'Maklumat telah dikemaskini',
                    type: 'success'
                }).then(() => {
                    var _tbody = $('#modal-man-login').find('#pcrs-tbl-peranan tbody');

                    $('#modal-peranan').modal('hide');
                    _tbody.find('tr').remove();

                    _.forEach(_.sortBy(senSubsPeranan, 'group_id'), function(value) {
                        var tr = $('<tr class="pcrs-row-peranan-subscribe" data_id='+ value.id +'/>');
                        var peranan = (value.group_id == 'PENGGUNA') ? $('<td><i class="fa fa-fw fa-diamond"></i></td>') : '<td/>;';

                        tr.append(peranan);
                        tr.append('<td style="width:1px">'+ value.group_id +'</td>');
                        tr.append('<td>'+ value.nama +'</td>');
                        _tbody.append(tr);
                    });
                });
            }).catch(function (error) {
                swal({
                    title: 'Ralat!',
                    text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                }).then(() => $('#modal-peranan').modal('hide'));
            });
        });
        
        $('#modal-man-login').on('click', '.btn-hapus-peranan', function(e) {
            e.preventDefault();

            var roleUser = $(this).data('role_user');
            
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
                preConfirm: (email) => {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            method: 'POST',
                            data: {'_method': 'DELETE'},
                            url: base_url+'rpc/pengguna/peranan/'+roleUser,                
                            success: function() {
                                resolve();
                            },
                            error: function(err) {
                                reject(err);
                            },
                            statusCode: login()
                        });
                    })
                }
            }).then((result) => {
                if (result.value) {
                    var modalBody = $('#modal-man-login').find('.modal-body');

                    swal({
                        title: 'Berjaya!',
                        text: 'Maklumat telah dihapuskan!',
                        type: 'success'
                    });

                    $.ajax({
                        url: base_url+'rpc/pengguna/'+mProfil.userId+'/login',
                        success: function(data, textStatus, jqXHR) {
                            modalBody.html(data);

                            $('#departmentsTree').on('select_node.jstree', function (e, data) {
                                var id = data.instance.get_node(data.selected[0]).id;
                                var text = data.instance.get_node(data.selected[0]).text;

                                $('.departmentDisplay').val(text);
                                $('.departmentDisplayId').val(id);
                                $("#treeDisplay").hide();
                            }).jstree({
                                core:{
                                    multiple : false,
                                    check_callback: true,
                                    data: departments
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if(jqXHR.status == 404)
                            {
                                modalBody.html(jqXHR.responseText);
                            }
                        },
                        complete: function() {
                            $('.internal').hide();
                            $('.external').hide();
                        }
                    });
                }
            }).catch(function (error) {
                swal({
                    title: 'Ralat!',
                    text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                });
            });
        });
        
        $('#modal-peranan').on('hidden.bs.modal', function(e) {
            var modalBody = $(this).find('.modal-body');

            modalBody.find('#ctxPeranan').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
            modalBody.find('#ctxJabatan').html('');
            pcrsAdjustBackdrop();
        });

        $('#modal-edit-peranan').on('show.bs.modal', function (e) {
            var descPeranan = $('#pcrs-tbl-peranan tbody tr[data_id='+subsPeranan+'] td:nth-child(3)');

            $(this).find('.modal-header').css('backgroundColor','#99CC00');
            $(this).find('.modal-header').css('color','white');
            $(this).find('.modal-title').html('KEMASKINI PERANAN : <b>' + descPeranan.text().toUpperCase() + '</b>');
            
            $('#treeDisplay3').jstree({
                core: {
                    multiple : false,
                    check_callback: true,
                    data: departments
                }
            });

            $('#departmentsTree3').on('select_node.jstree', function (e, data) {
                var id = data.instance.get_node(data.selected[0]).id;
                var text = data.instance.get_node(data.selected[0]).text;

                $('#departmentDisplay3').val(text);
                $('#departmentDisplayId3').val(id);
                $("#treeDisplay3").hide();
            });
        });


        $('#modal-edit-peranan').on('click', '#departmentDisplay3', function(e) {
            e.preventDefault();
            $('#departmentsTree3').css('width', $(this).parent().actual('width'));
            //$('#departmentsTree3').jstree('select_node', $('#departmentDisplayId2').val().toString());
            $('#treeDisplay3').toggle();

            $(document).click(function (e) {
                if (! $(e.target).hasClass("departmentDisplay") && $(e.target).parents("#treeDisplay3").length === 0) {
                    $("#treeDisplay3").hide();
                }
            });
        });

        $('#modal-edit-ppp').on('show.bs.modal', function (e) {
            populateDept2('#panel-department2', '#departments2', base_url+'rpc/anggota_penilai_grid', '#test');
        });

        $('#modal-edit-ppp').on('submit', '#frm-ppp', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var formEl = $(this);
            
            swal({
                title: 'Amaran!',
                text: 'Anda pasti untuk mengemaskini maklumat ini?',
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
                            data: formData,
                            cache       : false,
                            contentType : false,
                            processData : false,
                            url: base_url+'rpc/anggota/'+mProfil.userId+'/penilai',
                            success: function() {
                                resolve();
                            },
                            error: function(err) {
                                reject();
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
                    }).then(() => {

                        var modalBody = $('#modal-ppp').find('.modal-body');
            
                        $.ajax({
                            url: base_url+'rpc/anggota/'+mProfil.userId+'/penilai',
                            success: function(data, textStatus, jqXHR) {
                                modalBody.html(data);
                            }
                        });

                        modalBody.html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');

                        $('#modal-edit-ppp').modal('hide')
                    });
                }
            }).catch(function (error) {
                swal({
                    title: 'Ralat!',
                    text: 'Proses tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                });
            });
        });

        $('#modal-edit-ppp').on('hidden.bs.modal', function(e) {
            var options = $("#comSenPPP");
            options.children().remove();
            options.append(new Option('Loading...', 0));
            
            pcrsAdjustBackdrop();
        });

        function pcrsAdjustBackdrop()
        {
            var blur = $('.modal-backdrop:first').css('z-index') - 20;

            $('.modal-backdrop:first').css('z-index', blur);
        }

        $('#btn-base-bahagian').on('click', function(e) {
            e.preventDefault();
            openModal('#modal-base-bahagian', 'BASE BAHAGIAN');
        });

        $('#modal-base-bahagian').on('show.bs.modal', function(e) {
            getProfilEdit($(this).find('.modal-body'));

            function getProfilEdit($placeholder)
            {
                departments[0].state.selected=false;
                $.ajax({
                    url: base_url+'rpc/anggota/'+mProfil.userId+'/basebahagian',
                    success: function(data, textStatus, jqXHR) {
                        $placeholder.html(data);

                        $('#departmentsTree').jstree({
                            core:{
                                multiple : false,
                                check_callback: true,
                                data: departments
                            }
                        });
                        
                        $('#departmentsTree').on('select_node.jstree', function (e, data) {
                            var id = data.instance.get_node(data.selected[0]).id;
                            var text = data.instance.get_node(data.selected[0]).text;

                            $('.departmentDisplay').val(text);
                            $('.departmentDisplayId').val(id);
                            $("#treeDisplay").hide();
                        });
                    },
                    statusCode: login()
                });
            }
        });

        $('#modal-base-bahagian').on('submit', '#frm-xtra-attr', function(e) {

            e.preventDefault();
            
            var user_id = $('#txtDepartmentId').val();
            var formData = new FormData(this);

            swal({
                title: 'Amaran!',
                text: 'Anda pasti untuk mengemaskini maklumat ini?',
                type: 'warning',
                cancelButtonText: 'Tidak',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !swal.isLoading(),
                preConfirm: (email) => {
                    return new Promise((resolve,reject) => {
                         $.ajax({
                            method: 'post',
                            data: formData,
                            cache       : false,
                            contentType : false,
                            processData : false,
                            url: base_url+'rpc/anggota/'+mProfil.userId+'/basebahagian',
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
                    }).then(() => $('#modal-base-bahagian').modal('hide'));

                }
            }).catch(function (error) {
                swal({
                    title: 'Ralat!',
                    text: 'Pengemaskinian tidak berjaya!. Sila berhubung dengan Pentadbir sistem',
                    type: 'error'
                });
            });
        });

        $('#modal-base-bahagian').on('hidden.bs.modal', function(e) {
            e.preventDefault();
            $(this).find('.modal-body').html('<h4><i class="fa fa-refresh fa-spin"></i> Loading...</h4>');
        })

        $('#modal-base-bahagian').on('click', '#departmentDisplay', function(e) {
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

        $('#btn-flow-profil').on('click', function(e) {
            e.preventDefault();
            openModal('#modal-flow-profil', 'FLOW');
        });

        $('#modal-flow-profil').on('show.bs.modal', function(e) {

            $.ajax({
                url: base_url + 'rpc/anggota/' + mProfil.userId + '/flow',
                success: function(data, extStatus, jqXHR) {
                    console.log(data);
                    $('#info-flow-bahagian').text(data.data.flowbahagian.data.flow);

                    var option = $('<select id="com-flow-profil" class="form-control"></select>');
                    option.append('<option value="{{ $Flow::INHERIT }}" ' + ((data.data.flowanggota.data.flow == '{{ $Flow::INHERIT }}') ? '"selected"' : '') + '>{{ $Flow::INHERIT }}</option>');
                    option.append('<option value="{{ $Flow::BIASA }}" ' + ((data.data.flowanggota.data.flow == '{{ $Flow::BIASA }}') ? '"selected"' : '') + '>{{ $Flow::BIASA }}</option>');
                    option.append('<option value="{{ $Flow::KETUA }}" ' + ((data.data.flowanggota.data.flow == '{{ $Flow::KETUA }}') ? '"selected"' : '') + '>{{ $Flow::KETUA }}</option>');
                    $('#info-flow-profil').html(option.val(data.data.flowanggota.data.flow));


                    $('#loading').toggle();
                    $('#konfigurasi').toggle();
                }
            });
        });

        $('#info-flow-profil').on('change', '#com-flow-profil', function(e) {
            e.preventDefault();
            
            $.ajax({
                method: 'post',
                data:{'flag': e.target.value},
                url: base_url + 'rpc/anggota/' + mProfil.userId + '/flow',
                success: function( result, textStatus, jqXHR ) {
                    
                }
            });
        });

        $('#modal-flow-profil').on('hidden.bs.modal', function(e) {
            $('#loading').toggle();
            $('#konfigurasi').toggle();
        });

        $('#dg-anggota').on('click', '#detail-info', function() {
            var parent = $(this).parent().parent();

            mProfil.title = parent.data('nama');
            mProfil.userId = parent.data('userid');
            mProfil.deptId = parent.data('deptid');
            mProfil.deptName = parent.data('deptname');

            //console.log(mProfil);
            $('#detail-info-personal').show();
            $('#grid-wrapper').hide();

        });

        $('#detail-info-personal').on('click', '#back-wrapper', function(e) {
            $('#grid-wrapper').show();
            $('#detail-info-personal').hide();
        });

        function openModal(modal, header)
        {
            var modal = $(modal);

            modal.find('.modal-header').css('backgroundColor','steelblue');
            modal.find('.modal-header').css('color','white');
            modal.find('.modal-title').text(header+' : '+mProfil.title);

            modal.modal({backdrop: 'static', keyboard: false});
        }
    });
</script>

@endsection