<p>¿Esta Seguro que desea eliminar "{{$council->name}}"?</p>
<p>Escriba Eliminar en el campo para confirmar</p>

<form action="{{route("admin_councils_delete")}}" method="post" >
    @csrf
    <input type="hidden" name="council_id" value="{{$council->id}}"/>

    <input type="text" placeholder="Eliminar" id="confirm_delete">
    <button id="delete_button" disabled>Confirmar</button>
    <a href="{{route("admin_councils")}}">Cancelar</a>
</form>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $("#confirm_delete").keyup(function () {
            if($(this).val().toLowerCase()=="eliminar"){
                $("#delete_button").prop("disabled",false);
            } else {
                $("#delete_button").prop("disabled",true);
            }
        })
    });
</script>