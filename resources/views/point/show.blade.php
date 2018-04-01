@extends('layouts.home')

@section('title' , "Mostrar Punto")

@section('content')

<div class="card">
	<div class="card-body text-center">
		<h5 class="card-title"><a style="text-decoration: none;" href="{{route("get_diary",["diary_id"=>$point->diary->id])}}">Agenda del {{DateTime::createFromFormat("Y-m-d",$point->diary->event_date)->format("d/m/Y")}} - <b>{{$point->diary->council->name}}</b></a></h5>
		<p style="font-style: oblique;">"{{$point->diary->description}}"</p>
    	
    	<div class="card">
    		@if($point->pre_status=="propuesto" && !$point->post_status)
			<div style="background:#e8eaf6;" class="card-header text-black">
    		@elseif($point->pre_status=="incluido" && !$point->post_status)
			<div style="background:#5c6bc0;" class="card-header text-white">
			@elseif($point->pre_status=="desglosado" && !$point->post_status)
			<div style="background:#ffd54f;" class="card-header text-black">
			@elseif($point->post_status=="aprobado" && $point->pre_status=="incluido")
			<div style="background:#66bb6a;" class="card-header text-white">
			@elseif($point->post_status=="rechazado" && $point->pre_status=="incluido")
			<div style="background:#ef5350;" class="card-header text-white">
			@elseif(($point->post_status=="diferido" || $point->post_status=="diferido_virtual" || $point->post_status=="retirado" || $point->post_status=="presentado" || $point->post_status=="no_presentado") && $point->pre_status=="incluido")
			<div style="background:#78909c;" class="card-header text-white">
			@endif
  				@if($point->post_status)
    				<h5 class="card-title">Punto <b>@if($point->post_status=="diferido_virtual") diferido virtual @elseif($point->post_status=="no_presentado") no presentado @else {{$point->post_status}}@endif</b></h5>
    			@else
					<h5 class="card-title">Punto <b>{{$point->pre_status}}</b></h5>
				@endif
  			</div>
	  		<div class="card-body">
				<a class="btn btn-info" href="{{route("point_pdf",["point_id"=>$point->id])}}"><i class="fa fa-print" aria-hidden="true"></i></a>
				<br><br>
	  			<h5 class="card-title">Presentado por el/la {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h5>
	    		<h5 class="card-subtitle mb-2 text-muted">Descripción del punto</h5>
	    		<p id="description-{{$point->id}}" class="card-text">{{$point->description}}</p>
	    		<p id="type-{{$point->id}}">(Punto de {{$point->type=="info"?"información":"decisión"}})</p>

	    		@if($point->agreement)
	    			<h5 class="card-subtitle mb-2 text-muted">Acuerdo</h5>
	    			<h6 class="card-title">{{$point->agreement}}</h6>
	    		@endif

	    		@if(count($point->documents)>0)
	    			<br>
    				<h5 class="card-subtitle mb-2 text-muted">Documentos de soporte</h5>
	    		@endif
	    		@foreach($point->documents as $k => $document)
	    			@if(file_exists("docs/".$document->direction))
	    				<a target="_blank" href="{{asset("docs/".$document->direction)}}" class="btn btn-success">Documento {{$k+1}}</a>
	    			@endif
	    		@endforeach
	  		</div>
		</div>
 	</div>
</div>

@endsection