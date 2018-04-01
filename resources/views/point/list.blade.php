@extends('layouts.home')

@section('title' , "Puntos")

@section('links')
    
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
   
@endsection

@section('content')

@if($errors->any())
<br>
    <div style="text-align:center;" class="alert alert-danger" role="alert">
        {{$errors->first()}}
    </div>
@endif
@if(session('message_info'))
<br>
    <div style="text-align:center;" class="alert alert-success" role="alert">
        {{session('message_info')}}
    </div>
@endif
<h1 class="text-center mr1 font-weight-normal">Buscador de Puntos</h1>

<br>

<div class="table-responsive">
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	    <thead>
	        <tr>
                <th  scope="col">Fecha</th>
	            <th  scope="col">Presentador</th>
                <th  scope="col">Breve descripción</th>
                <th  scope="col">Tipo</th>
                <th  scope="col">Pre-status</th>
                <th  scope="col">Post-status</th>
                <th  scope="col">Acuerdo</th>
	            <th></th>
	        </tr>
	    </thead>
	</table>
</div>
<br>
@endsection

@section('script')
<script  src="{{ asset('js/moment.min.js') }}" ></script>
<script  src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script  src="{{ asset('js/dataTables.bootstrap4.min.js') }}" ></script>
<script  src="{{ asset('js/datetime-moment.js') }}" ></script>

<script>
    $(document).ready(function() {

        $.fn.dataTable.moment("DD-MM-YYYY");
        
        $('#table').DataTable( {
            "order": [[ 0, "desc" ]],
            "ajax": '{{route("get_points")}}',
            "columnDefs": [{ "orderable": false, "targets": -1 }],
            "iDisplayLength": 10,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ puntos",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando de _START_ a _END_ puntos de un total de _TOTAL_",
                "sInfoEmpty":      "No se ha registrado ningún punto",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ puntos)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        } );
    });
</script>
@endsection