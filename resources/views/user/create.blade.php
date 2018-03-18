@extends('layouts.home')

@section('title' , "Registrar usuario")


	@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
	
	<script type="text/javascript" src="{{ asset('js/create_user.js') }}"></script>
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-10 " action="" method="">
		<h1 class="text-center">Registrar Usuario</h1>
		<br><br>

	  	<div class="form-row">
		    <div class="form-group col-6">
		      	<label for="firstname_input">Nombre</label>
				<div class="input-group mb-3">
				  	<input name="name" type="text" id="firstname_input" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1" required autofocus onkeypress="return validar(event)"">
				</div>
		    </div>
		    <div class="form-group col-6">
		      	<label for="lastname_input">Apellido</label>
		      	<input name="last_name" type="text" class="form-control" id="lastname_input" placeholder="Apellido" required autofocus>
		    </div>
	  	</div>

	  	<div class="form-row">
		  	<div class="form-group col-6 " >
				<label for="ci_input">Cedula</label>
				<input name="ci" type="text" id="ci_input" class="form-control" placeholder="12345678" required autofocus onkeypress="return numeros(event) ">
			</div>
			<div class="form-group col-6">
				<label for="phone_input">Telefono</label>
				<div class="input-group mb-3">
				  	<input name="phone" type="text" id="phone_input" class="form-control" placeholder="04241234567" aria-label="Telefono" aria-describedby="basic-addon1" maxlength="11" minlength="11"  required autofocus onkeypress="return numeros(event)">
				</div>
			</div>
		</div>

		<div class="form-group ">
			<label for="email_input">Correo Electrónico</label>
			<div class="input-group mb-3">
			    <input name="email" type="email" id="email_input" class="form-control" placeholder="nombre@ejemplo.com" aria-label="Email" aria-describedby="basic-addon1" required autofocus>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-6">
			    <label for="consejo_input">Consejo</label>
			    <select class="form-control" id="consejo_input">
			    	<option selected>Seleccione...</option>
			      <option>1</option>
			      <option>2</option>
			      <option>3</option>
			      <option>4</option>
			      <option>5</option>
			    </select>
			  </div>
			  	<div class="form-group col-6">
			    <label for="rol_input">Rol</label>
			    <select class="form-control" id="rol_input">
			    	<option selected>Seleccione...</option>
			      <option>1</option>
			      <option>2</option>
			      <option>3</option>
			      <option>4</option>
			      <option>5</option>
			    </select>
			  </div>
		</div>
		<br>

		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary ">Registrar</button>
	  	</div>
	</form>

@endsection