@extends('layouts.home')

@section('title' , "Crear consejo")

@section('links')
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"> 
   
@endsection

@section('content')


@if($errors->any())
    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
@endif

@if(session('message_info'))
    {{session('message_info')}}
@endif
<div class="row justify-content-end">
    <div class=" col-lg-2 col-md-3 col-sm-4 ">
        <a class="btn  mr1 btn-outline-dark  "  href="{{route("admin_users_create")}}" role="button">Crear usuario</a>
    </div>
</div>
<br>

<div class="table-responsive">
<table id="table" class="table-striped mr1 " cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Correo</th>
            <th>Nombre </th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Rol</th>
            <th>Consejo</th>
            <th></th>
        </tr>
    </thead>
</table>
</div>

@endsection

@section('script')
<script  src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script  src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script  src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            "ajax": '{{route("get_admin_users")}}',
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