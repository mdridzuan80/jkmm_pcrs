<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }} - {{ env('APP_SHORT_NAME') }}</title>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

<!--datatable!-->

<link rel="stylesheet" href="{{ asset('datatable/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatable/css/buttons.dataTables.min.css') }}">

<!--
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
-->
<!--tutup datatable !-->


<script type="text/javascript">
$(document).ready(function () {
$('#datatable_1w').DataTable({
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
    $('#datatable_1q').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

</script> 
  

  <style>
    .table-fixed thead {
    width: 98%;
    }
    .table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
    }
    .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
    display: block;
    }
    .table-fixed tbody td, .table-fixed thead > tr> th {
    float: left;
    border-bottom-width: 0;
    }
	
	
	div.dataTables_wrapper {
        margin-bottom: 3em;
    }
	
</style>

</head>
<body class="hold-transition skin-blue sidebar-mini fixed">

<div class="row">
<div class="col-md-8 col-md-offset-2" style="margin-top:50px; margin-bottom:50px;">

<div class="row">
<div class="col-md-12">

<table id="datatable_1w" class="table table-hover table-striped" style="font-size: 14px !important;">
      <thead>
            <tr>
                <th width="5%" align="center">#</th>
                <th>Nama</th>
                <th width="10%" align="center">Tarikh</th>
            </tr>
     </thead>
     <tbody>                                   
            <tr>
                <td>1.</td>
                <td>Ali</td>
                <td>01.01.2022</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Abu</td>
                <td>02.01.2022</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Ahmad</td>
                <td>03.01.2022</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Abu</td>
                <td>04.01.2022</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Ahmad</td>
                <td>05.01.2022</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Ali</td>
                <td>01.01.2022</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>Abu</td>
                <td>02.01.2022</td>
            </tr>
            <tr>
                <td>8.</td>
                <td>Ahmad</td>
                <td>03.01.2022</td>
            </tr>
            <tr>
                <td>9.</td>
                <td>Abu</td>
                <td>04.01.2022</td>
            </tr>
            <tr>
                <td>10.</td>
                <td>Ahmad</td>
                <td>05.01.2022</td>
            </tr>
            <tr>
                <td>11.</td>
                <td>Ali</td>
                <td>01.01.2022</td>
            </tr>
            <tr>
                <td>12.</td>
                <td>Abu</td>
                <td>02.01.2022</td>
            </tr>
            <tr>
                <td>13.</td>
                <td>Ahmad</td>
                <td>03.01.2022</td>
            </tr>
            <tr>
                <td>14.</td>
                <td>Abu</td>
                <td>04.01.2022</td>
            </tr>
            <tr>
                <td>15.</td>
                <td>Ahmad</td>
                <td>05.01.2022</td>
            </tr>
            <tr>
                <td>16.</td>
                <td>Ali</td>
                <td>01.01.2022</td>
            </tr>
            <tr>
                <td>17.</td>
                <td>Abu</td>
                <td>02.01.2022</td>
            </tr>
            <tr>
                <td>18.</td>
                <td>Ahmad</td>
                <td>03.01.2022</td>
            </tr>
            <tr>
                <td>19.</td>
                <td>Abu</td>
                <td>04.01.2022</td>
            </tr>
            <tr>
                <td>20.</td>
                <td>Ahmad</td>
                <td>05.01.2022</td>
            </tr>
      </tbody>
    </table> 

</div>
</div>
</div>
</div>



<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!--
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
-->
<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.rowsGroup.js') }}"></script>


@yield('scripts')

</body>
</html>


