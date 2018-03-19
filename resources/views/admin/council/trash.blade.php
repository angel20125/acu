@extends('layouts.home')

@section('title' , "Eliminar consejo")

@section('links')
    <link href="{{ asset('css/create_user.css') }}" rel="stylesheet"> 

@endsection

@section('content')


@if($errors->any())
    @foreach ($errors->all() as $error)
        {{$error}}
    @endforeach
@endif

<div class="row justify-content-center text-center">
    <form class="form-signin col-lg-8 col-md-10 col-sm-12" action="{{route("admin_councils_delete")}}" method="post">
        @csrf
        <h1 class="text-center mr1 font-weight-normal">Eliminar consejo</h1>
        <br>
        <h5 class="text-center mr1 font-weight-normal">¿Esta seguro que desea eliminar "{{$council->name}}"?</h5>
        
        <div class="form-group col-10 offset-1">
            <label for="firstname_input">Escriba Eliminar en el campo para confirmar</label>
            <div class="input-group mb-3">
                <input type="hidden" name="council_id" value="{{$council->id}}"/>
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
