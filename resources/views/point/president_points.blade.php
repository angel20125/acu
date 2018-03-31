@extends('layouts.home')

@section('title' , "Puntos Propuestos")

@section('content')

@if($errors->any())
	<br>

    <div style="text-align:center;" class="alert alert-danger" role="alert">
	  	{{$errors->first()}}
	</div>
@endif
@if(session('message_info'))
	<br>
	<div style="text-align:center;" class="alert alert-success" role="alert">
			{{session('message_info')}}
	</div>
@endif

<div class="card">
	<div class="card-body" style="text-align: center;">
    	<h2 class="card-title">Puntos Propuestos</h2>
    	<p class="card-subtitle mb-2 text-muted">En esta sección se presentarán los diversos puntos que han propuesto los miembros de los consejos que usted preside y tiene como deber incluirlos o desglosarlos en sus agendas correspondientes.</p>

    	<br>

    	@foreach($user->councils as $council)
    		@if($user->getCurrentRol()->id===$council->pivot->role_id)
	    		@foreach($council->diaries->sortByDesc("event_date") as $diary)
		    		@if($diary->limit_date >= $current_date)
		    			@if(count($diary->points->where("pre_status","propuesto"))>0)
			  				<h5 class="card-title"><a style="text-decoration: none;" href="{{route("get_diary",["diary_id"=>$diary->id])}}">Agenda del {{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}} - <b>{{$council->name}}</b></a></h5>
			  				<p style="font-style: oblique;">"{{$diary->description}}"</p>
			  			@endif
		    			@foreach($diary->points->where("pre_status","propuesto")->sortByDesc("created_at") as $key => $point)
					    	<div class="card">
					    		@if($point->pre_status=="propuesto" && !$point->post_status)
		    					<div style="background:#e8eaf6; color: black;" class="card-header">
					    		@elseif($point->pre_status=="incluido" && !$point->post_status)
		    					<div style="background:#5c6bc0; color: white;" class="card-header">
			    				@elseif($point->pre_status=="desglosado" && !$point->post_status)
		    					<div style="background:#ffd54f; color: black;" class="card-header">
			    				@elseif($point->post_status=="aprobado" && $point->pre_status=="incluido")
		    					<div style="background:#66bb6a; color: white;" class="card-header">
			    				@elseif($point->post_status=="rechazado" && $point->pre_status=="incluido")
		    					<div style="background:#ef5350; color: white;" class="card-header">
								@elseif(($point->post_status=="diferido" || $point->post_status=="diferido_virtual" || $point->post_status=="retirado" || $point->post_status=="presentado" || $point->post_status=="no_presentado") && $point->pre_status=="incluido")
		    					<div style="background:#78909c; color: white;" class="card-header">
	    						@endif
					    			<h5 class="card-title">Punto <b>{{$point->pre_status}}</b></h5>
					  			</div>
						  		<div class="card-body">
			    					<a class="btn btn-info" href="{{route("point_pdf",["point_id"=>$point->id])}}"><i class="fa fa-print" aria-hidden="true"></i></a>
			    					<br><br>
						  			<h5 class="card-title">Presentado por el/la {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h5>
						    		<h5 class="card-subtitle mb-2 text-muted">Descripción del punto</h5>
						    		<p class="card-text">{{$point->description}}</p>
						    		<p>(Punto de {{$point->type=="info"?"información":"decisión"}})</p>

						    		@if(count($point->documents)>0)
						    			<br>
					    				<h5 class="card-subtitle mb-2 text-muted">Documentos de soporte</h5>
						    		@endif
						    		@foreach($point->documents as $k => $document)
						    			@if(file_exists("docs/".$document->direction))
						    				<a target="_blank" href="{{asset("docs/".$document->direction)}}" class="btn btn-success">Documento {{$k+1}}</a>
						    			@endif
						    		@endforeach

						    		<br><br>

						    		<a href="{{route("evaluate_presidente_points",["point_id"=>$point->id,"evaluation"=>"incluido"])}}" class="btn btn-primary">Incluir</a>
						    		<a href="{{route("evaluate_presidente_points",["point_id"=>$point->id,"evaluation"=>"desglosado"])}}" class="btn btn-danger">Desglosar</a>
						  		</div>
							</div>
		    			@endforeach
	    				<br><br>
	    			@endif
	    		@endforeach
    		@endif
    	@endforeach
	</div>
</div>
<br>
@endsection