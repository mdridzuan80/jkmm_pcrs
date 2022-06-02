
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


$(document).ready(function () {
$('#datatable_2').DataTable({
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

             
             
             <?php
			
			 
			 // Declare two dates
			$date1 = $txtTarikh;
			$date2 = $txtTarikhHingga;
			  
			// Declare an empty array
			$arraydate = array();
			  
			// Use strtotime function
			$Variable1 = strtotime($date1);
			$Variable2 = strtotime($date2);
			  
			// Use for loop to store dates into array
			// 86400 sec = 24 hrs = 60*60*24 = 1 day
			for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
												  
			$Store = date('Y-m-d', $currentDate);
			$arraydate[] = $Store;
			
			}
			
			$bil_kira = 1;

			?>
            

            
<table id="datatable_1" class="table table-hover table-striped" style="font-size: 14px !important;">
  <thead>
        <tr>
            <th width="10%" style="text-align:center;">#</th>
            <th>Nama</th>
            <th width="25%" style="text-align:center;">Tarikh</th>
            <th width="20%" style="text-align:center;">Data2</th>
        </tr>
  </thead>
  <tbody>   
        

        @foreach ($list_namastaf_department as $data_nama)
            
            @foreach ($arraydate as $datetarikh)
            
            <?php
			if(date("l", strtotime($datetarikh)) == 'Sunday'){
				$hari_malay = 'Ahad';
			}
			if(date("l", strtotime($datetarikh)) == 'Monday'){
				$hari_malay = 'Isnin';
			}
			if(date("l", strtotime($datetarikh)) == 'Tuesday'){
				$hari_malay = 'Selasa';
			}
			if(date("l", strtotime($datetarikh)) == 'Wednesday'){
				$hari_malay = 'Rabu';
			}
			if(date("l", strtotime($datetarikh)) == 'Thursday'){
				$hari_malay = 'Khamis';
			}
			if(date("l", strtotime($datetarikh)) == 'Friday'){
				$hari_malay = 'Jumaat';
			}
			if(date("l", strtotime($datetarikh)) == 'Saturday'){
				$hari_malay = 'Sabtu';
			}
			?>
            
            <tr>
                <td align="center"><?php echo $bil_kira++; ?>.</td>
                <td>
                            
                     {{ $data_nama->nama }}
                                
                </td>
                <td align="center">{{ $hari_malay.', '.date("d/m/Y", strtotime($datetarikh)) }}</td>
                <td align="center">
                
                	    
                      @foreach ($list_checkinout as $data_checkinout)
                        
                        
                        @if ((strpos($data_checkinout->checktime, date("Y-m-d", strtotime($datetarikh))) !== false) AND ($data_nama->anggota_id == $data_checkinout->userid))
                        
                        
                        	{{ date("h:i:s A", strtotime($data_checkinout->checktime)) }}
                            <br />
                        
                        @endif
                        
                    
                    @endforeach
                
                </td>
            </tr>
            
            @endforeach 
    
        @endforeach
   
  </tbody>
</table>
    
   			