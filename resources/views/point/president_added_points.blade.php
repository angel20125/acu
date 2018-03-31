@extends('layouts.home')

@section('title' , "Puntos Incluidos")

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
    	<h2 class="card-title">Puntos Incluidos</h2>
    	<p class="card-subtitle mb-2 text-muted">En esta sección se presentarán los diversos puntos que has incluido en el pasado en los diversos consejos que presides.</p>

    	<br>

    	@foreach($user->councils as $council)
    		@if($user->getCurrentRol()->id===$council->pivot->role_id)
	    		@foreach($council->diaries->sortByDesc("event_date") as $diary)
	    			@if(count($diary->points->where("user_id",$user->id))>0)
		  				<h5 class="card-title"><a style="text-decoration: none;" href="{{route("get_diary",["diary_id"=>$diary->id])}}">Agenda del {{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}} - <b>{{$council->name}}</b></a></h5>
		  				<p style="font-style: oblique;">"{{$diary->description}}"</p>
	  				@endif
	    			@foreach($diary->points->sortByDesc("created_at") as $key => $point)
	    				@if($point->user_id==$user->id)
					    	<div class="card">
					  			<div class="card-header">
					  				@if($point->post_status)
					    				<h5 class="card-title">Punto <b>@if($point->post_status=="diferido_virtual") diferido virtual @elseif($point->post_status=="no_presentado") no presentado @else {{$point->post_status}}@endif</b></h5>
					    			@else
				    					<h5 class="card-title">Punto <b>{{$point->pre_status}}</b></h5>
				    				@endif
					  			</div>
						  		<div class="card-body">
						  			<h5 class="card-title">Presentado por usted {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h5>
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
						    				<a target="_blank" href="{{asset("docs/".$document->direction)}}" class="btn btn-success">Documento {{$k+1}}</a>
						    			@endif
						    		@endforeach
						  		</div>
							</div>
						@endif
	    			@endforeach
	    		
	    		@endforeach
    		@endif
    	@endforeach
    </div>
</div>
<br>
@endsection