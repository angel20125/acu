@extends('layouts.login')

@section('title' , "¡Error inesperado!")

@section('links')
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="card">
		<h5 style="background:#ef5350; color: white;" class="card-header">¡Error inesperado!</h5>
		<div class="card-body">
			<p class="card-title">¡Ups, algo ha salido mal!. Te invitamos a hacer <a style="text-decoration: none;" href="{{route("home")}}"><b>clic aquí</b></a> para ir a la página principal.</p>
		</div>
	</div>
@endsection