

@extends('layouts.home')

@section('title' , "Registrar Usuario")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-md-10 col-sm-12 " action="{{route("admin_users_create")}}" method="post" enctype="multipart/form-data">
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
		<h1 class="text-center font-weight-normal">Registrar Usuario</h1>
		<br><br>

	  	<div class="form-row">
		    <div class="form-group col-md-6 col-sm-12">
		      	<label for="firstname_input">Nombre</label>
				<div class="input-group mb-3">
				  	<input name="first_name" type="text" id="first_name" class="form-control" placeholder="Nombre" aria-label="Nombre"  aria-describedby="basic-addon1" required autofocus onkeypress="return validar(event)">
				</div>
		    </div>
		    <div class="form-group col-md-6 col-sm-12">
		      	<label for="lastname_input">Apellido</label>
		      	<input name="last_name" type="text" class="form-control" id="last_name" placeholder="Apellido" required autofocus onkeypress="return validar(event)">
		    </div>
	  	</div>

	  	<div class="form-row">
		  	<div class="form-group col-md-6 col-sm-12 " >
				<label for="identity_card">Cédula</label>
				<input name="identity_card" type="text" id="identity_card" class="form-control" placeholder="12345678" required autofocus onkeypress="return numeros(event) ">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="phone_input">Teléfono</label>
				<div class="input-group mb-3">
				  	<input name="phone_number" type="text" id="phone_number" class="form-control" placeholder="04241234567" aria-label="Telefono" aria-describedby="basic-addon1" maxlength="11" minlength="11"  required autofocus onkeypress="return numeros(event)">
				</div>
			</div>
		</div>

	  	<div class="form-row">
		  	<div class="form-group col-md-6 col-sm-12 " >
				<label for="email_input">Correo Electrónico</label>
				<input name="email" type="email" id="email" class="form-control" placeholder="nombre@ejemplo.com" aria-label="Email" aria-describedby="basic-addon1" required autofocus>
			</div>
			<div class="form-group col-md-6 col-sm-12">
			    <label for="position_id">Cargo</label>
			    <select name="position_id" class="form-control" id="position_id" required>
			       	@foreach($positions as $position)
	            		<option value="{{$position->id}}">{{$position->name}}</option>
	        		@endforeach
			    </select>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-6">
			    <label for="council_id">Consejo</label>
			    <select name="council_id[]" class="form-control" id="council_id" required>
			       	@foreach($councils as $council)
	            		<option value="{{$council->id}}">{{$council->name}}</option>
	        		@endforeach
			    </select>
			</div>
		  	<div class="form-group col-6">
			    <label for="rol_input">Rol</label>
			    <select name="roles[]" class="form-control" id="rol" required>
			    	@foreach($roles as $rol)
	        			@if($rol->name!="admin" && $rol->name!="secretaria")
	            			<option value="{{$rol->name}}">{{$rol->display_name}}</option>
	            		@endif
	        		@endforeach
			    </select>
			  </div>
		</div>

		<br>
	 	<div id="inputRol"></div>

		<div class="justify-content-end text-right">
            <button id="btn-add" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Rol Extra</button>
        </div>

		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary ">Registrar</button>
	  	</div>

	  	
	</form>
</div>

@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('js/create_user.js') }}"></script>

    <script>
        $(document).ready(function() {
            var inputRol = $("#inputRol");
            var i=0;
            
            $("#btn-add").click(function() {
                i++;
                addNew();
            });

            function addNew() 
            {
                inputRol.append('<div class="rol-'+i+'"><div class="row justify-content-between" style="padding: 0em 15px !important" ><h3 class="text-center font-weight-normal" >Rol Extra</h3><button value="'+i+'" type="button" id="remove-rol-'+i+'" class="btn btn-danger"><i class="fa fa-trash text-right" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Eliminar Rol"></i></button></div><div class="form-row"><div class=" col-sm-6 form-group"><label for="council_id">Consejo</label><select name="council_id[]" class="form-control" id="council_id" required>@foreach($councils as $council)<option value="{{$council->id}}">{{$council->name}}</option>@endforeach</select></div><div class=" col-sm-6 form-group"><label for="rol_input">Rol</label><select name="roles[]" class="form-control" id="rol" required>@foreach($roles as $rol)@if($rol->name!="admin" && $rol->name!="secretaria") <option value="{{$rol->name}}">{{$rol->display_name}}</option> @endif @endforeach</select></div></div></div>');

	            $("#remove-rol-"+i).click(function(event) {
	                $(".rol-"+$(this).val()).remove();
	            });
            }
        });
    </script>
@endsection
