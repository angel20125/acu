@extends('layouts.home')

@section('title' , "Eliminar Cargo")

@section('links')
    <link href="{{ asset('css/create_user.css') }}" rel="stylesheet"> 

@endsection

@section('content')

<div class="row justify-content-center text-center">
    <form class="form-signin col-lg-8 col-md-10 col-sm-12" action="{{route("admin_positions_delete")}}" method="post">
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
        @csrf
        <h1 class="text-center mr1 font-weight-normal">Eliminar Cargo</h1>
        <br>
        <h5 class="text-center mr1 font-weight-normal">¿Esta seguro que desea eliminar el cargo "{{$position->name}}"?</h5>
        
        <div class="form-group col-10 offset-1">
            <label for="firstname_input">Escriba Eliminar en el campo para confirmar</label>
            <div class="input-group mb-3">
                <input type="hidden" name="position_id" value="{{$position->id}}"/>
                <input type="text" id="confirm_delete" class="form-control" placeholder="Eliminar" >
            </div>
        </div>
        <div class="justify-content-center text-center">
            <button id="delete_button" class="btn btn-primary " disabled>Confirmar</button>
        </div>
        <div class="justify-content-center text-center">
            <a href="{{route("admin_councils")}}"><br>Cancelar</a>
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
