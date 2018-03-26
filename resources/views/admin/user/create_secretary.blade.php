@extends('layouts.home')

@section('title' , "Registrar Secretaria")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form id="formulario" class="form-signin col-md-10 col-sm-12 " action="{{route("admin_users_create_secretary")}}" method="post" enctype="multipart/form-data">
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
		<h1 class="text-center font-weight-normal">Registrar Secretaria</h1>
		<br><br>

	  	<div class="form-row">
		    <div class="form-group col-md-6 col-sm-12">
		      	<label for="firstname_input">Nombre</label>
				<div class="input-group mb-3">
				  	<input name="first_name" type="text" id="first_name" class="form-control" placeholder="Nombre" aria-label="Nombre"  aria-describedby="basic-addon1" required autofocus onkeypress="return validar(event)" onkeyup="vali()">
				</div>
		    </div>
		    <div class="form-group col-md-6 col-sm-12">
		      	<label for="lastname_input">Apellido</label>
		      	<input name="last_name" type="text" class="form-control" id="last_name" placeholder="Apellido" required autofocus onkeypress="return validar(event)" onkeyup="vali()">
		    </div>
	  	</div>

	  	<div class="form-row">
		  	<div class="form-group col-md-6 col-sm-12 " >
				<label for="identity_card">Cédula</label>
				<input name="identity_card" type="text" id="identity_card" class="form-control" placeholder="12345678" required autofocus onkeypress="return numeros(event) " onkeyup="vali()">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="phone_input">Teléfono</label>
				<div class="input-group mb-3">
				  	<input name="phone_number" type="text" id="phone_number" class="form-control" placeholder="04241234567" aria-label="Telefono" aria-describedby="basic-addon1" maxlength="11" minlength="11"  required autofocus onkeypress="return numeros(event)" onkeyup="vali()">
				</div>
			</div>
		</div>

	  	<div class="form-row">
		  	<div class="form-group col-md-6 col-sm-12 " >
				<label for="email_input">Correo Electrónico</label>
				<input name="email" type="email" id="email" class="form-control" placeholder="nombre@ejemplo.com" aria-label="Email" aria-describedby="basic-addon1" required autofocus onkeyup="vali()">
			</div>
			<div class="form-group col-6">
			    <label for="position_boss_id">Cargo Autorizante</label>
			    <select name="position_boss_id" class="form-control" id="position_boss_id" required onkeyup="vali()">
			       	@foreach($positions as $position)
	            		<option value="{{$position->id}}">{{$position->name}}</option>
	        		@endforeach
			    </select>
			</div>
		</div>

		<br>
		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary">Registrar</button>
	  	</div>

	</form>
</div>

@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('js/create_user.js') }}"></script>
@endsection
