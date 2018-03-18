<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

@if($errors->any())
    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
@endif

@if(session('message_info'))
    {{session('message_info')}}
@endif

<a href="{{route("admin_users_create")}}">Crear usuario</a>

<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Correo electrónico</th>
            <th>Nombre y apellido</th>
            <th>Cédula de identidad</th>
            <th>Número de teléfono</th>
            <th>Rol</th>
            <th>Consejo</th>
            <th></th>
        </tr>
    </thead>
</table>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

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