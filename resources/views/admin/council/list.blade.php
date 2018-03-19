@extends('layouts.home')

@section('title' , "Consejos")

@section('links')
    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
   
@endsection

@section('content')

<br>
@if($errors->any())
    <div class="alert alert-danger" role="alert">
        {{$errors->first()}}
    </div>
@endif
@if(session('message_info'))
    <div class="alert alert-success" role="alert">
        {{session('message_info')}}
    </div>
@endif
 
<div class="row justify-content-end">
    <div class=" col-lg-2 col-md-3 col-sm-4 ">
        <a class="btn  mr1 btn-outline-dark  "  href="{{route("admin_councils_create")}}" role="button">Crear Consejo</a>
    </div>
</div>
<br>

<div class="table-responsive">
<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th  scope="col">Nombre del consejo</th>
            <th  scope="col">Fecha de creación</th>
            <th  scope="col"><i class="fa fa-sync"></i></th>
        </tr>
    </thead>
</table>
</div>

@endsection

@section('script')


<script  src="{{ asset('js/jquery-1.12.4.js') }}" ></script>
<script  src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script  src="{{ asset('js/dataTables.bootstrap4.min.js') }}" ></script>


<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            "ajax": '{{route("get_admin_councils")}}',
            "columnDefs": [{ "orderable": false, "targets": -1 }],
            "iDisplayLength": 10,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ consejos",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando de _START_ a _END_ consejos de un total de _TOTAL_",
                "sInfoEmpty":      "No se ha registrado ningún consejo",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ consejos)",
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