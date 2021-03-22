@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-book"></i></i> Laporan Bulanan
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive">
                        <form id="frm-laporan-bulanan">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td width="1"><b>BULAN-TAHUN</b></td>
                                        <td>
                                            <input type="text" class="form-control" name="txtTarikh" id="txtTarikh" autocomplete="off" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="1"><b>BAHAGIAN/&nbsp;UNIT</b></td>
                                        <td>
                                            <div style="position: relative;">
                                                <input id="departmentDisplay" class="form-control departmentDisplay" type="text" readonly style="background-color: #FFF;" placeholder="Sila pilih bahagian/ Unit" required>
                                                <input id="departmentDisplayId" type="hidden" name="txtDepartmentId" class="form-control departmentDisplayId" required>
                                                <div id="treeDisplay" style="display:none;">
                                                    <div id="departmentsTree" style="position:relative; background-color: #FFF; overflow:auto; max-height:200px; border:1px #ddd solid"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>PEGAWAI</b></td>
                                        <td>
                                            <select id="comSenPPP" name="comPegawai[]" multiple size="13" class="form-control" required>
                                                <option disabled>Sila pilih Bahagian/ Unit</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <button type="submit" id="btn-export-PDF" class="btn btn-default btn-flat">Jana PDF</button>
                                            <button type="reset" class="btn btn-default btn-flat">Reset</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                        <div id="lala">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {
            var margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };

            populateDept();

            $('#txtTarikh').datepicker({
                format: "M-yyyy",
                startView: "months", 
                minViewMode: "months"
            })

            function populateDept()
            {
                var departments = '';

                $.ajax({
                    url: base_url+'rpc/department_tree',
                    dataType: 'json',
                    success: function( result, textStatus, jqXHR ) {
                        departments = result;
                        
                        $('#departmentsTree').jstree({
                            core:{
                                multiple : false,
                                check_callback: true,
                                data: departments
                            }
                        });
                        
                        $('#departmentDisplay').prop('disabled', false);

                        $('#departmentsTree').on('select_node.jstree', function (e, data) {
                            var id = data.instance.get_node(data.selected[0]).id;
                            var text = data.instance.get_node(data.selected[0]).text;

                            $('.departmentDisplay').val(text);
                            $('.departmentDisplayId').val(id);
                            $("#treeDisplay").hide();

                            getSenaraiAnggota(id);
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
                    }
                });
            }

            function getSenaraiAnggota(departmentId) {
                var options = $("#comSenPPP");
                options.children().remove();
                options.append(new Option('Loading...', 0));

                $.ajax({
                    method:'post',
                    data: {
                        searchKey: "",
                        subDept:"true",
                        searchDept: departmentId
                    },
                    url: base_url+'rpc/anggota_penilai_grid',
                    success: function(data, textStatus, jqXHR) {
                        options.children().remove();

                        $.each(data.data, function(key, val) {
                            options.append(new Option(val.nama+' ('+val.jawatan+')', val.anggota_id, false));
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    },
                    statusCode: login()
                });
            }

            $('#frm-laporan-bulanan').on('submit', function(e) {
                e.preventDefault();
                
                if(e.target.txtDepartmentId.value) {
                    var formData = new FormData(this);

                    $.ajax({
                        method: 'post',
                        data: formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        url: base_url+'rpc/laporan/bulanan',
                        dataType: 'json',
                        success: function( result, textStatus, jqXHR ) {
                            exportPDF(result);
                        }
                    });
                }
            });

            function exportPDF(results) {

                try {
                    var doc = new jsPDF('p', 'pt', 'a4');
                    var totalPagesExp = "{total_pages_count_string}";
                    var i = 0;
                    results.forEach(function(row) {
                        var result = row.events;
                        var head = [["TARIKH", "MASUK", "KELUAR", "JAM", "KESALAHAN", "CATATAN", "TT"]];
                        var body = result.filter((item) =>
                            item.table_name == 'final').map((item)=>[moment(item.start).format("DD-MM-YYYY"), (item.check_in) ? moment(item.check_in).format("h:mm A") : '', (item.check_out) ? moment(item.check_out).format("h:mm A") : '', '']);                        
                        //var totalPagesExp = "{total_pages_count_string}";

                        if(i != 0) {
                            doc.addPage();
                        }

                        doc.autoTable({
                            head,
                            body,
                            theme: 'grid',
                            showHead: 'firstPage',
                            margin: {top: 75, bottom: 85},
                            headStyles: {fontSize: 8},
                            columnStyles: {
                                0: {cellWidth: 50, fontSize:8},
                                1: {halign: "center", fontSize:8},
                                2: {halign: "center",  fontSize:8},
                                3: {halign: "center",  fontSize:8},
                                4: {cellWidth: 80,  fontSize:8},
                                5: {cellWidth: 170,  fontSize:8}
                            },
                            didParseCell: function(data) {
                                if (data.row.section == 'head') {
                                    data.cell.styles.fillColor = [54, 54, 54];
                                    data.cell.styles.halign = "center";

                                    if(data.column.dataKey === '0') {
                                        data.cell.styles.halign = "left";
                                    }

                                    if(data.column.dataKey === '4') {
                                        data.cell.styles.halign = "left";
                                    }
                                }
                        
                                if(moment(result[data.row.index].start).format('d') === '0' || moment(result[data.row.index].start).format('d') === '6' || result[data.row.index].cuti ) {
                                    if (data.row.section == 'body') {
                                        data.cell.styles.fillColor = [240, 240, 240];
                                    }
                                }

                                if (data.row.section == 'body' && data.column.dataKey == '0') {
                                    console.log(result[data.row.index].start);
                                    data.cell.text = moment(result[data.row.index].start).format('DD (ddd)');
                                }

                                if (data.row.section == 'body' && data.column.dataKey == '4') {
                                    var justifikasi = '';
                                    console.log("huhu");
                                    if(result[data.row.index].tatatertib_flag == 'TS') {
                                        var kesalahan = JSON.parse(result[data.row.index].kesalahan);

                                        kesalahan.forEach(function(item, index) {
                                            switch(item) {
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
                                    
                                    if(result[data.row.index].cuti) {
                                        justifikasi += "Cuti Umum : " + result[data.row.index].cuti.perihal + "\r\n";
                                    }

                                    if(result[data.row.index].justifikasi) {
                                        result[data.row.index].justifikasi.forEach(function(item, index) {
                                            //if(index === 0 && item.flag_kelulusan === 'LULUS') {
                                            if(index == 0) {
                                                if(item.flag_justifikasi === 'SAMA') {
                                                    justifikasi += "J : " + item.keterangan + "\r\n";
                                                } else {
                                                    justifikasi += "JPG : " + item.keterangan + "\r\n";
                                                }
                                            }

                                            //if(index === 1 && item.flag_kelulusan === 'LULUS' && item.flag_justifikasi === 'XSAMA') {
                                            if(index == 1 && item.flag_justifikasi == 'XSAMA') {
                                                justifikasi += "JPTG : " + item.keterangan + "\r\n";
                                            }
                                        });
                                    }

                                    data.cell.text = justifikasi;
                                }
                            },
                            didDrawPage: function (data) {
                                // Header
                                doc.setFontSize(9);
                                doc.setFontStyle('normal');
                                /* if (base64Img) {
                                    doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 10, 10);
                                } */                        
                                doc.setFontSize(9);
                                doc.text("LAPORAN KEHADIRAN BULANAN", data.settings.margin.left, 30);
                                doc.text("Nama : " + row.name, data.settings.margin.left, 40);
                                doc.text("Jabatan/ Bahagian/ Unit : " + row.deptname, data.settings.margin.left, 50);
                                doc.text("Bulan : " + row.bulan, data.settings.margin.left, 60);
                                doc.text("Warna Kad : " + row.warna, data.settings.margin.left, 70);
                                

                                // Footer
                                var str = "Muka " + doc.internal.getNumberOfPages()

                                // Total page number plugin only available in jspdf v1.0+
                                if (typeof doc.putTotalPages == 'function') {
                                    str = str + " drp " + totalPagesExp;
                                }
                                doc.setFontSize(9);

                                // jsPDF 1.4+ uses getWidth, <1.4 uses .width
                                var pageSize = doc.internal.pageSize;
                                var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                                var pageWidth = doc.internal.pageSize.width ? doc.internal.pageSize.width : doc.internal.pageSize.getWidth();
                                
                                doc.text("T/ T PEGAWAI", data.settings.margin.left, pageHeight - 70);
                                doc.writeText(data.settings.margin.left - 80, pageHeight - 70 , "T/ T KETUA UNIT/ BAHAGIAN", { align: 'right' });
                                doc.text("Tarikh :", data.settings.margin.left, pageHeight - 40);
                                doc.writeText(data.settings.margin.left - 175, pageHeight - 40 , "Tarikh :", { align: 'right' });

                                doc.text("{{ env('APP_NAME') }}", data.settings.margin.left, pageHeight - 20);
                                doc.text("Dicetak pada : "+moment().format("lll")+", Oleh : {{(Auth::user()->xtraAnggota) ? Auth::user()->xtraAnggota->nama : Auth::user()->name }}", data.settings.margin.left, pageHeight - 10, 'left');
                                doc.writeText(data.settings.margin.left + 20, pageHeight - 10 ,str, { align: 'right' });
                            }
                        });
                        i++;
                    });

                    // Total page number plugin only available in jspdf v1.0+
                    if (typeof doc.putTotalPages == 'function') {
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