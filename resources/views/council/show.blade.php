@extends('layouts.home')

@section('title' , "Mostrar Consejo")

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}"> 
@endsection

@section('content')

<div class="card">
	<div class="card-body" style="text-align: center;">
    	<h2 class="card-title">{{$council->name}}</h2>
    	<h5 class="card-subtitle mb-2 text-muted">Presidente</h5>
    	<p style="font-style: oblique;" class="card-text">{{$council->president==null?"NA":$council->president->last_name." ".$council->president->first_name}}</p>
    	<h5 class="card-subtitle mb-2 text-muted">Adjunto</h5>
    	<p style="font-style: oblique;" class="card-text">{{$council->adjunto==null?"NA":$council->adjunto->last_name." ".$council->adjunto->first_name}}</p>

    	<h5 class="card-subtitle mb-2 text-muted">Miembros</h5>
    	
    	<div class="table-responsive">
			<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			    <thead>
			        <tr>
			            <th>Usuario </th>
			            <th>Cédula</th>
			            <th>Correo</th>
			            <th>Teléfono</th>
			            <th>Rol</th>
			        </tr>
			    </thead>
			</table>
		</div>
  </div>
</div>

@endsection

@section('script')

<script  src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script  src="{{ asset('js/dataTables.bootstrap4.min.js') }}" ></script>

<script>
    $(document).ready(function() {

        $('#table').DataTable( {
            "ajax": '{{route("get_list_members",["council_id"=>$council->id])}}',
            "columnDefs": [{ "orderable": false, "targets": -1 }],
            "iDisplayLength": 10,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ usuarios",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando de _START_ a _END_ usuarios de un total de _TOTAL_",
                "sInfoEmpty":      "No se ha registrado ningún usuario",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ usuarios)",
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