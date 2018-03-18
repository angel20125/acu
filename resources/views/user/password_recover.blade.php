@extends('layouts.login')

@section('links')
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('title' , "Recuperar contraseña")

@section('content')

<form class="form-signin" action="{{route("post_password_reset")}}" method="post">
	@if($errors->any())
	<h4>{{$errors->first()}}</h4>
	@endif
	@csrf
	<img class="mb-4" src="{{ asset('img/icon_uneg.png') }}" alt="" width="74" height="74">
  		<h1 class="h3 mb-3 font-weight-normal">Recuperar Contraseña</h1>
	  	<div class="form-group">
	   		<label for="email_input">Email</label>
	    	<input name="email" type="email" class="form-control" id="email_input" aria-describedby="emailHelp" placeholder="Email" required autofocus>
	  	</div>
	  	<div>
	  		<button type="submit" class="btn btn-primary">Recuperar Contraseña</button>
	  	</div>
	  	<label>
			<a href="{{route("login")}}" ><br> ¿La recordaste? Ingresa</a>
		</label>	
	</form>

@endsection