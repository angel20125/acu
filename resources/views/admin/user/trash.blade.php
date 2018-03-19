@extends('layouts.home')

@section('title' , "Eliminar Usuario")

@section('links')
    <link href="{{ asset('css/create_user.css') }}" rel="stylesheet"> 

@endsection

@section('content')

<div class="row justify-content-center text-center">
    <form class="form-signin col-lg-8 col-md-10 col-sm-12" action="{{route("admin_users_delete")}}" method="post">
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
        @csrf
        <h1 class="text-center mr1 font-weight-normal">Eliminar Usuario</h1>
        <br>
        <h5 class="text-center mr1 font-weight-normal">¿Esta seguro que desea eliminar el usuario "{{$edit_user->first_name}} {{$edit_user->last_name}}"?</h5>
        
        <div class="form-group col-10 offset-1">
            <label for="firstname_input">Escriba Eliminar en el campo para confirmar</label>
            <div class="input-group mb-3">
                <input type="hidden" name="user_id" value="{{$edit_user->id}}"/>
                <input type="text" id="confirm_delete" class="form-control" placeholder="Eliminar" required>
            </div>
        </div>
        <div class="justify-content-center text-center">
            <button id="delete_button" class="btn btn-primary " disabled>Confirmar</button>
        </div>
        <div class="justify-content-center text-center">
            <a href="{{route("admin_users")}}"><br>Cancelar</a>
        </div>
        
    </form>
</div>

@endsection
@section('script')

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
@endsection