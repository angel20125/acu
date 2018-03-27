@extends('layouts.home')

@section('title' , "Mostrar Agenda")

@section('content')

<div class="card">
	<div class="card-body" style="text-align: center;">
    	<h2 class="card-title">{{$diary->council->name}}</h2>
    	<h5 class="card-subtitle mb-2 text-muted">Descripción de la agenda</h5>
    	<p style="font-style: oblique;" class="card-text">{{$diary->description}}</p>
    	<p class="card-text"><b>Lugar:</b> {{$diary->place}} <b>Fecha:</b> {{$diary->event_date}} <b>Estado:</b> {{$diary->status=="0"?"A tratar":"Tratada"}}</p>
    	<a class="btn btn-primary" href="{{route("admin_diaries")}}">Volver</a>
    	
    	<br><br>

    	@foreach($diary->points as $key => $point)
	    	<div class="card">
	  			<div class="card-header">
	    			<h5 class="card-title">Punto {{$key+1}}</h5>
	  			</div>
		  		<div class="card-body">
		  			<h5 class="card-title">Presentado por el {{$point->user->getCurrentRol()->display_name}} "{{$point->user->first_name}} {{$point->user->last_name}}"</h5>
		    		<h6 class="card-title">Descripción del punto</h6>
		    		<p class="card-text">{{$point->description}}</p>
		    		<p>(Punto de {{$point->type=="info"?"información":"decisión"}})</p>

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