@extends('layouts.master')

@section('content')
    <section class="content-header" style="margin-bottom:26px !important;">
        <h1 class="pull-left">
            <i class="fa fa-book"></i></i> Laporan Harian
        </h1>
        
        <div class="pull-right">
            <a href="/laporan" title="kembali">
            	<span class="glyphicon glyphicon-circle-arrow-left" style="font-size:30px;"></span>
            </a>
        </div>
        
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" >
                    <div class="box-body table-responsive">
                    
                        <!--<form id="frm-laporan-harian">-->
                        <form target="_blank" id="form-laporan-harian" name="laporan_harian" method="POST" action="{{ route('pdf.laporan.harian') }}">
                            <table class="table table-bordered">
                                <tbody>
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
                                        <td width="1"><b>TARIKH&nbsp;PAPARAN</b></td>
                                        <td>
                                            <!-- <input type="text" class="form-control" name="txtTarikh" id="txtTarikh" autocomplete="off" value="{{ now()->subDay()->format('Y-m-d') }}" required> -->
                                            <input type="text" class="form-control" name="txtTarikh" id="txtTarikh" autocomplete="off" value="{{ now()->format('Y-m-d') }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <!--
                                            <button type="submit" id="btn-export-PDF" class="btn btn-default btn-flat">Jana PDF</button>
                                            <button type="reset" class="btn btn-default btn-flat">Reset</button>
                                            -->
                                            
                                            <button type="button" id="cmdJanaLaporanHarianAll" class="btn btn-primary btn-flat" name="btn_papar">Hantar</button>
                                            <button type="submit" id="cmdJanaLaporanHarian_pdf" class="btn btn-success btn-flat" name="btn_pdf">Jana PDF</button>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        
                        <div class="row">
                            <div id="report_view" class="col-md-12"></div>
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
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true
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

            $('#frm-laporan-harian').on('submit', function(e) {
                e.preventDefault();
                
                if(e.target.txtDepartmentId.value) {
                    var formData = new FormData(this);

                    $.ajax({
                        method: 'post',
                        data: formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        url: base_url+'rpc/laporan/harian',
                        dataType: 'json',
                        success: function( result, textStatus, jqXHR ) {
                            exportPDF(e, result);
                        }
                    });
                }
            });
			
			
			
			$('#cmdJanaLaporanHarianAll').on('click', function(e) {	
		// $('#form-laporanrekodkehadiran1212').on('submit', function(e) {
			e.preventDefault();
		
			var departmentDisplayId = $("#departmentDisplayId").val();
			//var comSenPPP = $("#comSenPPP").val();
			var txtTarikh = $("#txtTarikh").val();
			//var txtTarikhHingga = $("#txtTarikhHingga").val();
		
					console.log(departmentDisplayId);
					//console.log(comSenPPP);
					console.log(txtTarikh);
					//console.log(txtTarikhHingga);
					
					$.ajax({
						url: base_url+'laporan/harian',
						method: 'POST',
				"headers": {
					"Accept": "application/json"
				},
			data: {
				'departmentDisplayId': departmentDisplayId,
				//'comSenPPP': comSenPPP,
				'txtTarikh': txtTarikh,
				//'txtTarikhHingga': txtTarikhHingga,
			},
				success: function(response){
					$('#report_view').html(response);
				}
			});
		});	
			
			

            function exportPDF(e, result) {
                var doc = new jsPDF('p', 'pt', 'a4');
                var head = [["BadgeNo.", "Kad", "Nama", "WBF", "Check-In", "Check-Out", "Info Lewat", "Catatan"]];
                var body = result.data.map((item)=>[item.badgenumber, 'K', item.nama, item.shift, (item.check_in) ? moment(item.check_in).format("h:mm A") : '', (item.check_out) ? moment(item.check_out).format("h:mm A") : '']);
                
                var totalPagesExp = "{total_pages_count_string}";

                doc.autoTable({
                    head,
                    body,
                    theme: 'grid',
                    showHead: 'firstPage',
                    margin: {top: 70},
                    didDrawPage: function (data) {
                        // Header
                        doc.setFontSize(16);
                        doc.setTextColor(40);
                        doc.setFontStyle('normal');
                        /* if (base64Img) {
                            doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 10, 10);
                        } */                        
                        doc.setFontSize(12);
                        doc.text("LAPORAN HARIAN KEHADIRAN PENUH", data.settings.margin.left, 30);
                        doc.text("Jabatan/ Bahagian/ Unit : " + result.bahagian, data.settings.margin.left, 45);
                        doc.text("Tarikh : " + moment(e.target.txtTarikh.value).format("D-MMM-YYYY"), data.settings.margin.left, 60);

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
            }
        });
    </script>
@endsection