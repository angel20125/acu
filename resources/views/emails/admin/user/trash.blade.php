@if($errors->any())
    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
@endif

<p>¿Esta seguro que desea eliminar el usuario "{{$edit_user->first_name}} {{$edit_user->last_name}}"?</p>
<p>Escriba Eliminar en el campo para confirmar</p>

<form action="{{route("admin_users_delete")}}" method="post" >
    @csrf
    <input type="hidden" name="user_id" value="{{$edit_user->id}}"/>

    <input type="text" placeholder="Eliminar" id="confirm_delete">
    <button id="delete_button" disabled>Confirmar</button>
    <a href="{{route("admin_users")}}">Cancelar</a>
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