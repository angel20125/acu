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
    	<h2 class="card-title">Puntos Incluidos</h2>
    	<p class="card-subtitle mb-2 text-muted">En esta sección se presentarán los diversos puntos que has incluido en el pasado en los diversos consejos que presides.</p>

    	<br><br>

    	@foreach($user->councils as $council)
    		@foreach($council->diaries as $diary)
  				<h5 class="card-title"><a style="text-decoration: none;" href="{{route("get_diary",["diary_id"=>$diary->id])}}">Agenda del {{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}} - <b>{{$council->name}}</b></a></h5>
	  				<p style="font-style: oblique;">"{{$diary->description}}"</p>
    			@foreach($diary->points->sortByDesc("created_at") as $key => $point)
    				@if($point->user_id==$user->id)
				    	<div class="card">
				  			<div class="card-header">
				    			<h5 class="card-title">Punto {{$point->pre_status=="incluido"?"Incluido":($point->pre_status=="desglosado"?"Desglosado":"Propuesto")}}</h5>
				  			</div>
					  		<div class="card-body">
					  			<h5 class="card-title">Presentado por usted {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h5>
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
					@endif
    			@endforeach
    		@endforeach
    	@endforeach

</div>
@endsection