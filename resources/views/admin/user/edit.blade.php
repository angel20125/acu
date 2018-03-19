@extends('layouts.home')

@section('title' , "Editar Usuario")

@section('links')
    <link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
    <form class="form-signin col-md-10 col-sm-12 " action="{{route("admin_users_update")}}" method="post" enctype="multipart/form-data">
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
        <h1 class="text-center font-weight-normal">Editar Usuario</h1>
        <br><br>
        <input type="hidden" name="user_id" value="{{$edit_user->id}}"/>
        <div class="form-row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="firstname_input">Nombre</label>
                <div class="input-group mb-3">
                    <input name="first_name" type="text" id="first_name" class="form-control" placeholder="Nombre" value="{{$edit_user->first_name}}"  required autofocus onkeypress="return validar(event)">
                </div>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="lastname_input">Apellido</label>
                <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Apellido" value="{{$edit_user->last_name}}" required autofocus onkeypress="return validar(event)">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6 col-sm-12 " >
                <label for="identity_card">Cedula</label>
                <input name="identity_card" type="text" id="identity_card" class="form-control" placeholder="12345678" required autofocus onkeypress="return numeros(event)" value="{{$edit_user->identity_card}}">
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="phone_input">Telefono</label>
                <div class="input-group mb-3">
                    <input name="phone_number" type="text" id="phone_number" class="form-control" placeholder="04241234567" aria-label="Telefono" aria-describedby="basic-addon1" maxlength="11" minlength="11"  required autofocus onkeypress="return numeros(event)" value="{{$edit_user->phone_number}}">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6  col-sm-12">
                 <label for="email_input">Correo Electrónico</label>
                 <div class="input-group mb-3">
                        <input name="email" type="email" id="email" class="form-control" placeholder="nombre@ejemplo.com" aria-label="Email" aria-describedby="basic-addon1" required autofocus value="{{$edit_user->email}}">
                </div>
             </div>
             <div class="form-group col-6  col-sm-12">
                <label for="rol_input">Estado</label>
                <select name="status" class="form-control" id="status" required>
                    <option @if($edit_user->status==1) selected @endif value="1">Activo</option>
                    <option @if($edit_user->status==0) selected @endif value="0">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="council_id">Consejo</label>
                <select name="council_id" class="form-control" id="council_id" required>
                    <option selected value="{{$currentCouncil->id}}">{{$currentCouncil->name}}</option>
                </select>
            </div>
            <div class="form-group col-6">
                <label for="rol_input">Rol</label>
                <select name="rol" class="form-control" id="rol" required>
                    @foreach($roles as $rol)
                        @if($rol->name!="admin")
                            <option {{$edit_user->hasRole($rol->name)?"selected":""}} value="{{$rol->name}}">{{$rol->display_name}}</option>
                        @endif
                    @endforeach
                    
                </select>
            </div>
        </div>
        <br>
        <div class="justify-content-center text-center">
            <button type="submit" class="btn btn-primary ">Registrar</button>
        </div>
        <div class="justify-content-center text-center">
            <a href="{{route("admin_users")}}"><br>Ver Usuarios</a>
        </div>
    </form>
</div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/create_user.js') }}"></script>
@endsection