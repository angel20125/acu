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

<br>

@php $startDate = DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('first day of this month')->format("w"); @endphp

<div class="table-responsive">
	<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	    <thead>
	        <tr>
	        	<th>Domingo</th>
	        	<th>Lunes</th>
	        	<th>Martes</th>
	        	<th>Miércoles</th>
	        	<th>Jueves</th>
	        	<th>Viernes</th>
	        	<th>Sábado</th>
	        </tr>
	    </thead>
	    </tbody>
	    	@php $count=0; $countDay=1; @endphp
	    	@for($i=1; $i <= 5; $i++)
	        <tr>
	        	@for($j=1; $j <= 7; $j++)
	        		@if($count < $startDate)
	        			<td>Día pasado</td>
	        		@elseif($count >= $startDate && $countDay <= DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('last day of this month')->format("d"))
	        			<td>{{$countDay}}/{{DateTime::createFromFormat("m/Y",gmdate("m/Y"))->format("m/Y")}}</td>
	        			@php $countDay++; @endphp
	        		@elseif($countDay > DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('last day of this month')->format("d"))
	        			<td>Día futuro</td>
	        		@endif
	        		@php $count++; @endphp
	        	@endfor
	        </tr>
	        @endfor
	    </tbody>
	</table>
</div>

@endsection

