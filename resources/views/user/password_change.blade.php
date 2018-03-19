@extends('layouts.login')

@section('links')
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('title' , "Recuperar contraseña")

@section('content')

<form class="form-signin" action="{{route("post_password_reset_token")}}" method="post">
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
	<img class="mb-4" src="{{ asset('img/icon_uneg.png') }}" alt="" width="74" height="74">
	<h1 class="h3 mb-3 font-weight-normal">Cambiar Contraseña</h1>
	<div class="form-group">
		<input name="token" type="hidden" value="{{$token}}"/>
		<label for="password_input">Nueva Contraseña</label>
		<input name="password" type="password" class="form-control" id="password_input" aria-describedby="emailHelp" placeholder="Contraseña" required autofocus>
	</div>
	<div>
		<button type="submit" class="btn btn-primary ">Cambiar Contraseña</button>
	</div>
	<label>
		<a href="{{route("login")}}" ><br> ¿La recordaste? Ingresa</a>
	</label>	
</form>

@endsection