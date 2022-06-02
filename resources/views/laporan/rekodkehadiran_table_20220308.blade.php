
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

$(document).ready(function() {
    $('#datatable_12').DataTable( {
        dom: 'Bfrtip',
	 lengthMenu: [
		[ 10, 25, 50, -1 ],
		[ '10 rows', '25 rows', '50 rows', 'Show all' ]
	], 
	
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

</script> 

<table id="datatable_1" class="table table-hover table-striped" style="font-size: 14px !important;">
  <thead>
  
            <tr>
                <th width="5%" align="center">#</th>
                <th>Nama</th>
                <th width="10%" align="center">Tarikh</th>
                <th width="10%" align="center">T & M</th>
                <th width="10%" align="center">Data2</th>
                <th width="10%">Jenis Punch</th>
                <th width="10%">Mesin</th>
            </tr>
  </thead>
  <tbody>          
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
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $l_rekodkehadiran->namaa }}</td>
                <!--<td>{{ (Auth::user()->xtraAnggota) ? Auth::user()->xtraAnggota->nama : Auth::user()->name }}</td>-->
                <td>{{ date("l d/m/Y", strtotime($l_rekodkehadiran->checktime)) }}</td>
                <td>
                
                <?php echo $txtTarikh.' - '.$txtTarikhHingga; ?>
                
                <?php 
                /*
                if($val['chkinout']) {
                    foreach($val['chkinout'] as $d) {
                        echo(date("g:i:s a", strtotime($d['checkinout'])) ."<br/>");
                    }
                }
                */
                ?>
                
                </td>
                <td>{{ $l_rekodkehadiran->checktime }}</td>
                <td>{{ $l_rekodkehadiran_jenispunch }}</td>
                <td>{{ $l_rekodkehadiran->sensorid }}</td>
            </tr>
            
              <?php //echo date("l d/m/Y", strtotime($l_rekodkehadiran->checktime))?>
                
            @endforeach
   
  </tbody>
</table>