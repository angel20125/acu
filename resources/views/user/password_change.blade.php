@extends('layouts.login')

@section('links')
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('title' , "Recuperar contraseña")

@section('content')

<form class="form-signin" action="" method="">
	@if($errors->any())
	<h4>{{$errors->first()}}</h4>
	@endif
	@csrf
	<img class="mb-4" src="{{ asset('img/icon_uneg.png') }}" alt="" width="74" height="74">
	<h1 class="h3 mb-3 font-weight-normal">Cambiar Contraseña</h1>
	<div class="form-group">
		<label for="password_input">Nueva Contraseña</label>
		<input type="password" class="form-control" id="password_input" aria-describedby="emailHelp" placeholder="Contraseña" required autofocus>
	</div>
	<div>
		<button type="submit" class="btn btn-primary ">Cambiar Contraseña</button>
	</div>
	<label>
		<a href="" ><br> ¿La recordaste? Ingresa</a>
	</label>	
</form>

@endsection