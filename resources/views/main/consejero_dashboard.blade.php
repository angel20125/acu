@extends('layouts.home')

@section('title' , "Inicio")

@section('links')
	
@endsection

@section('content')

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

@if(count($diaries)>0)
	<div class="row justify-content-center">
		@foreach($diaries as $key => $diary)
			@if($key < 3)
				<div class="card text-center col-lg-3 col-md-5 col-sm-10 pdd">
					<div class="card-body">
						<h5 class="card-title">{{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}}</h5>
						<p class="card-text">{{$diary->council->name}}</p>
						<a href="{{route("get_diary",["diary_id"=>$diary->id])}}" class="btn btn-primary">Ver Agenda</a>
					</div>
					<div class="card-footer text-muted">
						Lugar: {{$diary->place}}	
					</div>
				</div>
			@endif
		@endforeach
	</div>
@else
	<div class="row justify-content-center">
		<div class="card">
			<div class="card-body" style="text-align: center;">
				<h4>¡No se ha registrado ninguna agenda por ahora!</h4>
			</div>
		</div>
	</div>
@endif

<br>

<!-- Calendar -->
<div class="container-fluid">
<div class="row"> 
	@php $startDate = DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('first day of this month')->format("w"); @endphp
 	
 	@php 
 	$mes =	array(
    "01"  => "Enero",
    "02" => "Febrero",
    "03" => "Marzo",
    "04"  => "Abril",
    "05" => "Mayo",
    "06" => "Junio",
    "07"  => "Julio",
    "08" => "Agosto",
    "09" => "Septiembre",
    "10"  => "Octubre",
    "11" => "Noviembre",
    "12" => "Diciembre",
 	);
    $var = gmdate("m");
    @endphp
 	
 	<h3 class="font-weight-normal col-12 text-center">{{ $mes[$var] }}</h3>
 	<br><br>
	<div class="table-responsive col-lg-10 offset-lg-1 col-md-12">
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
		        			<td style="color: #BDBDBD">
		        				{{DateTime::createFromFormat("d/m/Y",gmdate("d/m/Y"))->modify('first day of this month')->sub(new DateInterval("P".$last_month."D"))->format("d")}}
		        			</td>
		        			@php $last_month--; @endphp

		        		@elseif($count >= $startDate && $countDay <= DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('last day of this month')->format("d"))
	        				@if($countDay==gmdate("d"))
			        			<td style="background:#28a745; color:white; font-weight: bold;">
			        				{{$countDay}}
			        				<br>
			        				@foreach($calendar as $cal)
										@foreach($cal as $key => $c)
											@if($key==$countDay)
												<a style="color:white;" href="{{route("get_diary",["diary_id"=>$c])}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
											@endif
										@endforeach
									@endforeach
			        			</td>
		        			@else
			        			<td style="font-weight: bold; ">
			        				{{$countDay}}
			        				<br>
			        				@foreach($calendar as $cal)
										@foreach($cal as $key => $c)
											@if($key==$countDay)
												<a href="{{route("get_diary",["diary_id"=>$c])}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
											@endif
										@endforeach
									@endforeach
			        			</td>
		        			@endif
		        			@php $countDay++; @endphp

		        		@elseif($countDay > DateTime::createFromFormat("Y-m-d",gmdate("Y-m-d"))->modify('last day of this month')->format("d"))
		        			<td style="color: #BDBDBD">
		        				{{DateTime::createFromFormat("d/m/Y",gmdate("d/m/Y"))->modify('first day of this month')->add(new DateInterval("P".$future_month."D"))->format("d")}}
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
</div>

@endsection
@section('script')

@endsection