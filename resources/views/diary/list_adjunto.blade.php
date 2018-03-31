@extends('layouts.home')

@section('title' , "Agendas Pendientes")

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
<h1 class="text-center mr1 font-weight-normal">Agendas Pendientes</h1>

<br>

<div class="table-responsive">
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Breve descripción</th>
                <th>Estado</th>
                <th>Consejo involucrado</th>
                <th>Presidente</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
<br>

@endsection

@section('script')

<script  src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script  src="{{ asset('js/dataTables.bootstrap4.min.js') }}" ></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            "order": [[ 0, "desc" ]],
            "ajax": '{{route("get_adjunto_diaries")}}',
            "columnDefs": [{ "orderable": false, "targets": -1 }],
            "iDisplayLength": 10,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ agendas",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "No tienes agendas pendientes por finalizar",
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