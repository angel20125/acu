@extends('layouts.home')

@section('title' , "Inicio")

@section('links')
	
@endsection

@section('content')

<div class="row justify-content-center">
	<div class="card text-center col-lg-3 col-md-5 col-sm-10">
		<div class="card-body">
			<h5 class="card-title">20/03/2018</h5>
			<p class="card-text">Juegos Universitarios</p>
			<a href="#" class="btn btn-primary">Ver reunión</a>
		</div>
		<div class="card-footer text-muted">
			hoy
		</div>
	</div>
	<div class="card text-center col-lg-3 col-md-5 col-sm-10">
		<div class="card-body">
			<h5 class="card-title">20/03/2018</h5>
			<p class="card-text">Situacion Comedor</p>
			<a href="#" class="btn btn-primary">Ver reunión</a>
		</div>
		<div class="card-footer text-muted">
			mañana
		</div>
	</div>

	<div class="card text-center col-lg-3 col-md-5 col-sm-10  d-md-none d-lg-block">
		<div class="card-body">
			<h5 class="card-title">20/03/2018</h5>
			<p class="card-text">Alargue de Semestre</p>
			<a href="#" class="btn btn-primary">Ver reunión</a>
		</div>
		<div class="card-footer text-muted">
			faltan 9 dias
		</div>
	</div>
	
</div>
<!-- Calendar -->
<div class="row"> 
	
</div>

@endsection
@section('script')

@endsection

