@extends('layouts.home')

@section('title' , "Editar Usuario")

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/create_user.css') }}">
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
        <br>
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
                <label for="identity_card">Cédula</label>
                <input name="identity_card" type="text" id="identity_card" class="form-control" placeholder="12345678" required autofocus onkeypress="return numeros(event)" value="{{$edit_user->identity_card}}">
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="phone_input">Teléfono</label>
                <div class="input-group mb-3">
                    <input name="phone_number" type="text" id="phone_number" class="form-control" placeholder="04241234567" aria-label="Telefono" aria-describedby="basic-addon1" maxlength="11" minlength="11"  required autofocus onkeypress="return numeros(event)" value="{{$edit_user->phone_number}}">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6  col-sm-12">
                 <label for="email_input">Correo Electrónico</label>
                 <div class="input-group mb-3">
                        <input name="email" type="email" id="email" class="form-control" placeholder="nombre@ejemplo.com" aria-label="Email" aria-describedby="basic-addon1" required autofocus value="{{$edit_user->email}}">
                </div>
             </div>
             <div class="form-group col-md-6  col-sm-12">
                <label for="rol_input">Estado</label>
                <select name="status" class="form-control" id="status" required>
                    <option @if($edit_user->status==1) selected @endif value="1">Activo</option>
                    <option @if($edit_user->status==0) selected @endif value="0">Inactivo</option>
                </select>
            </div>
        </div>

        @php $i=1; @endphp
        @foreach($edit_user->councils as $key => $council)
            <input type="hidden" name="councils_transactions[]" value="{{$council->id}}">
            <div class="rol-{{$key}}">
                <div class="row justify-content-between" style="padding-left: 12px; padding-right: 15px">
                    <h3 class="text-center font-weight-normal" >Rol Actual</h3>
                    @if($council->president_id!=$edit_user->id && $council->adjunto_id!=$edit_user->id)
                        <button value="{{$key}}" type="button" id="remove-rol-{{$key}}" class="btn btn-danger"><i class="fa fa-trash text-right" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Eliminar Rol"></i></button>
                    @endif
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="council_id">Consejo</label>
                        <select name="council_id[]" class="form-control" id="council_id" required>
                            @if($council->president_id==$edit_user->id)
                                <option selected value="{{$council->id}}">{{$council->name}}</option>
                            @elseif($council->adjunto_id==$edit_user->id)
                                <option selected value="{{$council->id}}">{{$council->name}}</option>
                            @else
                                @foreach($councils as $new_council)
                                    <option {{$council->id==$new_council->id?"selected":""}} value="{{$new_council->id}}">{{$new_council->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="rol_input">Rol</label>
                        <select name="roles[]" class="form-control" id="rol" required>
                            @if($council->president_id==$edit_user->id)
                                <option selected value="presidente">Presidente</option>
                            @elseif($council->adjunto_id==$edit_user->id)
                                <option selected value="adjunto">Adjunto</option>
                            @else
                                @foreach($roles as $rol)
                                    @if($rol->name!="admin" && $rol->name!="secretaria")
                                        <option {{$council->pivot->role_id==$rol->id?"selected":""}} value="{{$rol->name}}">{{$rol->display_name}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                @if($council->president_id==$edit_user->id)
                    <div class="alert alert-primary" role="alert">
                        <b>Nota:</b> Si deseas degradar el usuario de <b>Presidente</b>, debes hacerlo desde el <b>{{$council->name}} <i class="fa fa-edit" aria-hidden="true"></i></b>
                    </div>
                @elseif($council->adjunto_id==$edit_user->id)
                    <div class="alert alert-primary" role="alert">
                        <b>Nota:</b> Si deseas degradar el usuario de <b>Adjunto</b>, debes hacerlo desde el <b>{{$council->name}} <i class="fa fa-edit" aria-hidden="true"></i></b>
                    </div>
                @endif

            </div>
            @php $i++; @endphp
        @endforeach

        <br>
        <div id="inputRol"></div>

        <div class="justify-content-end text-right">
            <button id="btn-add" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Rol Extra</button>
        </div>

        <div class="justify-content-center text-center">
            <button type="submit" class="btn btn-primary ">Actualizar</button>
            <br>
            <a href="{{route("admin_users")}}"><br>Ver Usuarios</a>
        </div>
    </form>
</div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/create_user.js') }}"></script>

    <script>
        $(document).ready(function() {

            @foreach($edit_user->councils as $key => $council)
                $("#remove-rol-{{$key}}").click(function(event) {
                    $(".rol-"+$(this).val()).remove();
                });
            @endforeach

            var inputRol = $("#inputRol");
            var i={{$i}};

            $("#btn-add").click(function() {
                i++;
                addNew();
            });

            function addNew() 
            {
                inputRol.append('<div style="margin-bottom:50px;" class="rol-'+i+'"><div class="row justify-content-between" style="padding-left: 12px; padding-right: 15px"><h3 class="text-center font-weight-normal" >Rol Extra</h3><button value="'+i+'" type="button" id="remove-rol-'+i+'" class="btn btn-danger"><i class="fa fa-trash text-right" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Eliminar Rol"></i></button></div><div class="row"><div class="col-xs-12 col-sm-6"><label for="council_id">Consejo</label><select name="council_id[]" class="form-control" id="council_id" required>@foreach($councils as $council)<option value="{{$council->id}}">{{$council->name}}</option>@endforeach</select></div><div class="col-xs-12 col-sm-6"><label for="rol_input">Rol</label><select name="roles[]" class="form-control" id="rol" required> @foreach($roles as $rol) @if($rol->name!="admin" && $rol->name!="secretaria") <option value="{{$rol->name}}">{{$rol->display_name}}</option> @endif @endforeach</select></div></div></div></div>');

                $("#remove-rol-"+i).click(function(event) {
                    $(".rol-"+$(this).val()).remove();
                });
            }

        });
    </script>
@endsection

