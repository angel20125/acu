@extends('layouts.home')

@section('title' , "Inicio")

@section('links')
	
@endsection

@section('content')

<br>
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
			<h5 class="card-title">21/03/2018</h5>
			<p class="card-text">Situacion Comedor</p>
			<a href="#" class="btn btn-primary">Ver reunión</a>
		</div>
		<div class="card-footer text-muted">
			mañana
		</div>
	</div>

	<div class="card text-center col-lg-3 col-md-5 col-sm-10  d-md-none d-lg-block">
		<div class="card-body">
			<h5 class="card-title">30/03/2018</h5>
			<p class="card-text">Alargue de Semestre</p>
			<a href="#" class="btn btn-primary">Ver reunión</a>
		</div>
		<div class="card-footer text-muted">
			faltan 10 dias
		</div>
	</div>
	
</div>

<br>

<!-- Calendar -->
<div class="row"> 
	@php $startDate = DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('first day of this month')->format("w"); @endphp
	<div class="table-responsive">
		<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
		    <thead>
		        <tr style="text-align:center;">
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
		    	@php $count=0; $countDay=1; $last_month=7-(7-$startDate); $future_month=1; @endphp
		    	@for($i=1; $i <= 5; $i++)
		        <tr style="text-align:center;">
		        	@for($j=1; $j <= 7; $j++)

		        		@if($count < $startDate)
		        			<td>
		        				{{DateTime::createFromFormat("d/m/Y",gmdate("d/m/Y"))->modify('first day of this month')->sub(new DateInterval("P".$last_month."D"))->format("d/m/Y")}}
		        			</td>
		        			@php $last_month--; @endphp

		        		@elseif($count >= $startDate && $countDay <= DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('last day of this month')->format("d"))
	        				@if($countDay==gmdate("d"))
			        			<td style="background:#28a745; color:white;">
			        				{{$countDay}}/{{DateTime::createFromFormat("m/Y",gmdate("m/Y"))->format("m/Y")}}
			        			</td>
		        			@else
			        			<td>
			        				{{$countDay}}/{{DateTime::createFromFormat("m/Y",gmdate("m/Y"))->format("m/Y")}}
			        			</td>
		        			@endif
		        			@php $countDay++; @endphp

		        		@elseif($countDay > DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('last day of this month')->format("d"))
		        			<td>
		        				{{DateTime::createFromFormat("d/m/Y",gmdate("d/m/Y"))->modify('first day of this month')->add(new DateInterval("P".$future_month."D"))->format("d/m/Y")}}
		        			</td>
		        			@php $future_month++; @endphp
		        		@endif
		        		
		        		@php $count++; @endphp
		        	@endfor
		        </tr>
		        @endfor
		    </tbody>
		</table>
	</div>
</div>

@endsection
@section('script')

@endsection

