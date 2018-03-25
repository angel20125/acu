@extends('layouts.home')

@section('title' , "Editar Perfil")

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/create_user.css') }}">
@endsection

@section('content')

    <div class="row justify-content-center">
        <form class="form-signin col-md-10 col-sm-12 " action="{{route("save_profile")}}" method="post" enctype="multipart/form-data">
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
            <h1 class="text-center font-weight-normal">Editar Perfil</h1>
            <h4 class="text-center font-weight-normal">Aquí puedes modificar tu información basica</h4>
            <br><br>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="firstname_input">Nombre</label>
                    <input name="first_name" value="{{$user->first_name}}" type="text" id="firstname_input" class="form-control" placeholder="Nombre" required autofocus onkeypress="return validar(event)">
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="lastname_input">Apellido</label>
                    <input name="last_name" value="{{$user->last_name}}" type="text" class="form-control" id="lastname_input" placeholder="Apellido" required autofocus onkeypress="return validar(event)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="ci_input">Cédula</label>
                    <input name="identity_card" value="{{$user->identity_card}}" type="text" id="ci_input" class="form-control" placeholder="12345678" required autofocus onkeypress="return numeros(event)">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="phone_input">Teléfono</label>
                    <input name="phone_number" value="{{$user->phone_number}}" type="text" id="phone_input" class="form-control" placeholder="04241234567"  maxlength="11" minlength="11" autofocus required onkeypress="return numeros(event)">
                </div>
            </div>
            <div class="form-group">
                <label for="email_input">Correo Electrónico</label>
                <input name="email" value="{{$user->email}}" type="email" id="email_input" class="form-control" placeholder="nombre@ejemplo.com">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="consejo_input">Consejo </label>
                    <select id="consejo_input" class="form-control" disabled>
                        @if($user->hasRole("presidente")||$user->hasRole("consejero")||$user->hasRole("secretaria")||$user->hasRole("adjunto"))
                            <option selected disabled>{{$user->councils->first()->name}}</option>
                        @else
                            <option selected disabled>Ninguno</option>
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="role_input">Rol</label>
                    <select id="role_input" class="form-control" disabled>
                        <option selected disabled>{{$user->getCurrentRol()->display_name}}</option>
                    </select>
                </div>
            </div> 
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password_input">Contraseña</label>
                    <input name="password" type="password" id="password_input" class="form-control" placeholder="Contraseña" autofocus> 
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="confirm_password_input">Confirmar Contraseña</label>
                    <input name="confirm_password" type="password" class="form-control" id="confirm_password_input" placeholder="Confirmar Contraseña"  autofocus>
                </div>
            </div>              
            <br>
            <div class="justify-content-center text-center">
                <button type="submit" class="btn btn-primary ">Guardar Cambios</button>
                <br>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/create_user.js') }}"></script>
@endsection

