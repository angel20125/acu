@extends('layouts.home')

@section('title' , "Editar Perfil")

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/create_user.css') }}">
@endsection

@section('content')

    <div class="row justify-content-center">
        <form class="form-signin col-md-10 col-sm-12 " action="" method="post" enctype="multipart/form-data">
            <h1 class="text-center font-weight-normal">Editar Perfil</h1>
            <h4 class="text-center font-weight-normal">Aqui puedes modificar tu información básica  </h4>
            <br><br>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="firstname_input">Nombre</label>
                    <input type="text" id="firstname_input" class="form-control" placeholder="Nombre" required autofocus onkeypress="return validar(event)">
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="lastname_input">Apellido</label>
                    <input type="text" class="form-control" id="lastname_input" placeholder="Apellido" required autofocus onkeypress="return validar(event)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password_input">Contraseña</label>
                    <input type="password" id="password_input" class="form-control" placeholder="Password" autofocus required> 
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="confirm_password_input">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="confirm_password_input" placeholder="Password"  autofocus required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="phone_input">Teléfono</label>
                    <input type="text" id="phone_input" class="form-control" placeholder="Telefono"  maxlength="11" minlength="11" autofocus required onkeypress="return numeros(event)">
                    </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="ci_input">Cédula</label>
                    <input type="text" id="ci_input" class="form-control" placeholder="Cedula" required autofocus onkeypress="return numeros(event)">
                </div>
            </div>
            <div class="form-group">
                <label for="email_input">Correo Electrónico</label>
                <input type="email" id="email_input" class="form-control" placeholder="Email">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="role_input">Rol</label>
                    <select id="role_input" class="form-control" disabled>
                        <option selected disabled>Seleccione...</option>
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="consejo_input">Consejo </label>
                    <select id="consejo_input" class="form-control" disabled>
                        <option selected disabled>Seleccione...</option>
                    </select>
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

