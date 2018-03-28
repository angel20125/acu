@extends('layouts.home')

@section('title' , "Mostrar Agenda")

@section('content')

<div class="card">
	<div class="card-body" style="text-align: center;">
    	<h2 class="card-title">{{$diary->council->name}}</h2>
    	<h5 class="card-subtitle mb-2 text-muted">Descripción de la agenda</h5>
    	<p style="font-style: oblique;" class="card-text">{{$diary->description}}</p>
    	<p class="card-text"><b>Lugar:</b> {{$diary->place}} <b>Fecha:</b> {{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}} <b>Estado:</b> {{$diary->status=="0"?"En espera de la reunión":"Finalizada"}}</p>
    	
    	<br>

    	@foreach($diary->points->where("pre_status","incluido")->sortByDesc("created_at") as $key => $point)
	    	<div class="card">
	  			<div class="card-header">
	  				@if($point->post_status)
	    				<h5 class="card-title">Punto <b>@if($point->post_status=="diferido_virtual") diferido virtual @elseif($point->post_status=="no_presentado") no presentado @else {{$point->post_status}}@endif</b></h5>
	    			@else
	    				<h5 class="card-title">Punto Incluido</h5>
    				@endif
	  			</div>
		  		<div class="card-body">
		  			<h5 class="card-title">Presentado por el {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h5>
		    		<h5 class="card-subtitle mb-2 text-muted">Descripción del punto</h5>
		    		<p class="card-text">{{$point->description}}</p>
		    		<p>(Punto de {{$point->type=="info"?"información":"decisión"}})</p>

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
		    				<a href="{{asset("docs/".$document->direction)}}" class="btn btn-success">Documento {{$k+1}}</a>
		    			@endif
		    		@endforeach
		  		</div>
			</div>
    	@endforeach
  </div>
</div>

@endsection