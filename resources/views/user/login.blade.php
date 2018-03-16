@extends('layouts.login')

@section('links')
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('title' , "Ingresar")


@section('content')

	<form class="form-signin" action="{{route("post_login")}}" method="post">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
        @csrf
		<img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="74" height="74">
		<h1 class="h3 mb-3 font-weight-normal">Iniciar Sesión</h1>
		
		<input name="email" type="email" id="inputEmail" class="form-control" placeholder="Correo Electrónico" required autofocus>
		
		<input name="password" type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Recuérdame
			</label>
		</div>
		<div>
			<button class="btn  btn-primary " type="submit">Ingresar</button>
		</div>
		<label>
			<a href="" ><br> ¿Olvidaste tu contraseña? </a>
		</label>		
	</form>

@endsection

