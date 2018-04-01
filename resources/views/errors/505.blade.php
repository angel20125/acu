@extends('layouts.login')

@section('title' , "¡Error inesperado!")

@section('links')
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
	<link href="{{ asset('css/fa-svg-with-js.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="card ">
		<div class="justify-content-between card-header" style="background:#ef5350;">
		
		<h5  class=" text-white "><i class="fas fa-exclamation-triangle mrr"></i>¡Error inesperado!<i class="fas fa-exclamation-triangle mrl" ></i></h5>
		
		</div>
		<div class="card-body">
			<h4 class="font-weight-normal"> ¡Ups, algo ha salido mal!</h4>
			<p class="card-title">Te invitamos a hacer <a style="text-decoration: none;" href="{{route("home")}}"><b>clic aquí</b></a> para ir a la página principal.</p>
		</div>
	</div>
@endsection

@section('script')
	<!-- Icons -->
	<script  src="{{ asset('js/fontawesome-all.min.js') }}" ></script>
	
@endsection