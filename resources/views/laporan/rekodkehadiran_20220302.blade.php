@inject('Checkinout', 'App\Checkinout')

@extends('layouts.master')

<script type="text/javascript"> 
/*
$(document).ready(function() {
    $('#datatable_1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
*/
</script>

<script type="text/javascript">
$(document).ready(function () {
$('#datatable_1').DataTable({
"scrollX": false,
 //"searching": false,
 dom: 'Bfrtip',
	 lengthMenu: [
		[ 10, 25, 50, -1 ],
		[ '10 rows', '25 rows', '50 rows', 'Show all' ]
	], 

	buttons: [

		'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'

	] 
 
});
$('.dataTables_length').addClass('bs-select');
});
</script> 

<!--script datable !-->



@php
    $list_checkinout = $collection['list_checkinout'];
@endphp


@section('content')
    <section class="content-header" style="margin-bottom:26px !important;">
        <h1 class="pull-left">
            <i class="fa fa-book"></i></i> Laporan Rekod Kehadiran
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
                        <form id="form-laporanrekodkehadiran789" enctype="multipart/form-data">
                        <!--<form id="form-laporanrekodkehadiran" name="rekod_kehadiran" method="POST" action="{{ route('laporan.rekodkehadiran') }}" enctype="multipart/form-data">-->
                                @csrf
                                
                                <table class="table table-bordered" style="font-size:14px !important;">
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
                                        <td><b>PEGAWAI</b></td>
                                        <td>
                                            <!--<select id="comSenPPP" name="comPegawai[]" multiple size="13" class="form-control" required>-->
                                            <select id="comSenPPP" name="comPegawai" class="form-control" required>
                                                <option value="0">Sila pilih Bahagian/ Unit</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="1"><b>TARIKH&nbsp;PAPARAN&nbsp;DARI</b></td>
                                        <td>
                                            <input type="text" class="form-control" name="txtTarikh" id="txtTarikh" autocomplete="off" value="{{ now()->subDay()->format('Y-m-d') }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="1"><b>TARIKH&nbsp;PAPARAN&nbsp;HINGGA</b></td>
                                        <td>
                                            <input type="text" class="form-control" name="txtTarikhHingga" id="txtTarikhHingga" autocomplete="off" value="{{ now()->subDay()->format('Y-m-d') }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <button type="submit" id="cmdJanaLaporanKehadiranAll789" class="btn btn-primary btn-flat" name="btn_papar">Hantar</button>
                                            <!--<button type="button" id="btn-export-PDF" class="btn btn-default btn-flat">Jana PDF</button>
                                            <button type="reset" class="btn btn-default btn-flat">Reset</button>-->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                        <div id="lala789">

                        </div>
                        
                        <div id="rst-lpt-kehadiran789">
                            &nbsp;
                        </div>
                        
                        
   
                        
                        
                    <div class="row">
                        <div class="col-md-12">
                        
              
                          
                          <?php
                                //if (isset($_POST['btn_hantar_kelulusan'])) {					
                                    //echo $_POST['kategori_acara'];
                                //}
                                
                                $nombor = 1;
                                $kira = 0;
                                $content = 'test'
                            ?>
                            
                            <table id="datatable_1" class="table table-hover table-striped" style="font-size: 14px !important;">
                              <tbody>
                              
                                        <tr>
                                            <th width="5%" align="center">#</th>
                                            <th>Nama</th>
                                            <th width="10%" align="center">Tarikh & Masa</th>
                                            <th width="10%">Jenis Punch</th>
                                            <th width="10%">Mesin</th>
                                        </tr>
                                        
                                         @foreach ($list_checkinout as $l_rekodkehadiran)
                                          
                                          @php
                                            if($l_rekodkehadiran->checktype == 'I'){
                                                $l_rekodkehadiran_jenispunch = 'In';
                                            }
                                            elseif($l_rekodkehadiran->checktype == 'O'){
                                                $l_rekodkehadiran_jenispunch = 'Out';
                                            }
                                            elseif($l_rekodkehadiran->checktype == 'i'){
                                                $l_rekodkehadiran_jenispunch = 'Keluar Site';
                                            }
                                            elseif($l_rekodkehadiran->checktype == '1'){
                                                $l_rekodkehadiran_jenispunch = 'Balik Site';
                                            }
                                            else{
                                                $l_rekodkehadiran_jenispunch = '-';
                                            }
                                        @endphp
                                        
                                        
                                        <tr>
                                            <td><?php echo $nombor++; ?>.</td>
                                            <td>{{ $l_rekodkehadiran->namaa }}</td>
                                            <!--<td>{{ (Auth::user()->xtraAnggota) ? Auth::user()->xtraAnggota->nama : Auth::user()->name }}</td>-->
                                            <td>{{ $l_rekodkehadiran->checktime }}</td>
                                            <td>{{ $l_rekodkehadiran_jenispunch }}</td>
                                            <td>{{ $l_rekodkehadiran->sensorid }}</td>
                                        </tr>
                                        
                                          
                                            
                                        @endforeach
                                        
                             
                                   
                               
                              </tbody>
                            </table>
                        
                     </div>
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

            $('#txtTarikhHingga').datepicker({
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

            $('#frm-laporan-rekodkehadiran').on('submit', function(e) {
                e.preventDefault();
                
                if(e.target.txtDepartmentId.value) {
                    var formData = new FormData(this);

                    $.ajax({
                        method: 'post',
                        data: formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        url: base_url+'rpc/laporan/rekodkehadiran',
                        dataType: 'json',
                        success: function( result, textStatus, jqXHR ) {
                            exportPDF(e, result);
                        }
                    });
                }
            });
			
			
			$('#form-laporanrekodkehadiran22').on('submit', function(e) {
                e.preventDefault();
                
                if(e.target.txtDepartmentId.value) {
                    var formData = new FormData(this);

                    $.ajax({
                        method: 'post',
                        data: formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        url: base_url+'rpc/laporan/rekodkehadiran',
                        dataType: 'json',
                        success: function( result, textStatus, jqXHR ) {
                            /*exportPDF(e, result);*/
                        }
                    });
                }
            });
			
			
				$('#cmdJanaLaporanKehadiranAll2').click(function(){
					var deptid = $('#departmentsTree').combotree('getValue');
					var staffid = $('#comSenPPP').val();
					var mula = $('#txtTarikh').val();
					var akhir = $('#txtTarikhHingga').val();
					$("#rst-lpt-kehadiran2").empty().html('<div class="att-loader"><img src="'+base_url+'public/images/loading.gif" /></div>');
					$('#rst-lpt-kehadiran2').load(base_url+'rpc/laporan/rekodkehadiran', {'deptid': deptid, 'staffid':staffid, 'mula':mula, 'akhir':akhir});
				})


            function exportPDF(e, result) {
                var doc = new jsPDF('p', 'pt', 'a4');
                var head = [["Badge Number", "Nama", "WBF", "Tarikh", "Data-Data"]];
                var body = result.data.map((item)=>[item.badgenumber, item.nama, item.shift, (item.check_in) ? moment(item.check_in).format("h:mm A") : '', (item.check_out) ? moment(item.check_out).format("h:mm A") : '']);
                
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
                        doc.text("LAPORAN REKOD KEHADIRAN PENUH", data.settings.margin.left, 30);
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
    
    
    <script type="text/javascript">

        $(document).ready(function(){

            $("#negeri").change(function(){

                var negeri = $("#negeri").val();

                //alert(negeri);

                console.log(negeri);

                $.ajax({

                    url: "{{ url('main/ajaxbandar') }}/" + negeri,

                    type: 'GET',

                    success: function(msg){

                        $("#bandar").html(msg); ////note: jangan lupe declare url dkt route. kalau tak fropdown tak jalan///

                    }

                });

            });



        });

    </script>
    
@endsection