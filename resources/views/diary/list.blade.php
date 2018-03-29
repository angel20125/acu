@extends('layouts.home')

@section('title' , "Agendas")

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')


@if($errors->any())
    <div style="text-align:center;" class="alert alert-danger" role="alert">
        {{$errors->first()}}
    </div>
@endif
@if(session('message_info'))
    <div style="text-align:center;" class="alert alert-success" role="alert">
        {{session('message_info')}}
    </div>
@endif
 <h1 class="text-center mr1 font-weight-normal">Lista de Agendas</h1>
<div class="form-group">
    <div class="  text-right pdr">
        <a class="btn  mr1 btn-outline-dark  "  href="{{route("admin_diaries_create")}}" role="button">Registrar Agenda</a>
    </div>
</div>
<br>

<div class="table-responsive">
<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Breve descripción</th>
            <th>Consejo involucrado</th>
            <th>Presidente</th>
            <th></th>
        </tr>
    </thead>
</table>
</div>

@endsection

@section('script')

<script  src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script  src="{{ asset('js/dataTables.bootstrap4.min.js') }}" ></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            "ajax": '{{route("get_admin_diaries")}}',
            "columnDefs": [{ "orderable": false, "targets": -1 }],
            "iDisplayLength": 10,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ agendas",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando de _START_ a _END_ agendas de un total de _TOTAL_",
                "sInfoEmpty":      "No se ha registrado ninguna agenda",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ agendas)",
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