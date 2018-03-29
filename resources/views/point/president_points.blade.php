@extends('layouts.home')

@section('title' , "Puntos Propuestos")

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

<div class="card">
	<div class="card-body" style="text-align: center;">
    	<h2 class="card-title">Puntos Propuestos</h2>
    	<p class="card-subtitle mb-2 text-muted">En esta sección se presentarán los diversos puntos que han propuesto los miembros de los consejos que usted preside y tiene como deber incluirlos o desglosarlos en sus agendas correspondientes.</p>

    	<br><br>

    	@foreach($user->councils as $council)
    		@if($user->getCurrentRol()->id===$council->pivot->role_id)
	    		@foreach($council->diaries->sortByDesc("event_date") as $diary)
		    		@if($diary->limit_date >= gmdate("Y-m-d"))
		    			@if(count($diary->points->where("pre_status","propuesto"))>0)
			  				<h5 class="card-title"><a style="text-decoration: none;" href="{{route("get_diary",["diary_id"=>$diary->id])}}">Agenda del {{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}} - <b>{{$council->name}}</b></a></h5>
			  				<p style="font-style: oblique;">"{{$diary->description}}"</p>
			  			@endif
		    			@foreach($diary->points->where("pre_status","propuesto")->sortByDesc("created_at") as $key => $point)
					    	<div class="card">
					  			<div class="card-header">
					    			<h5 class="card-title">Punto <b>{{$point->pre_status}}</b></h5>
					  			</div>
						  		<div class="card-body">
						  			<h5 class="card-title">Presentado por el {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h5>
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
@endsection