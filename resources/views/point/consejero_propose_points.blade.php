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
    	<h2 class="card-title">Puntos</h2>
    	<p class="card-subtitle mb-2 text-muted">En esta sección se presentarán los diversos puntos que has presentado en el pasado en los diversos consejos que participas.</p>

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
				    					@if($point->pre_status=="propuesto" && gmdate("Y-m-d") <= $diary->event_date)
				    						<a href="{{route("delete_point",["point_id"=>$point->id])}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
				    						<button data-toggle="modal" data-target="#edit-point" value="{{$point->id}}" id="get-data-{{$point->id}}" type="button" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
				    					@endif
				    				@endif
					  			</div>
						  		<div class="card-body">
						  			<h5 class="card-title">Presentado por usted {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h5>
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
						@endif
	    			@endforeach
	    			<br><br>
	    		@endforeach
    		@endif
    	@endforeach
    </div>
</div>

<div id="edit-point" class="modal fade" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title">Editar Punto</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          	<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	      		<input type="hidden" id="id">
				<div class="form-row">
					<div class="form-group col-md-12 col-sm-12">
			   			<label for="description">Descripción</label>
			    		<textarea name="description" class="form-control" id="description" rows="3" placeholder="Resúmen general de la temática a tratar en la agenda" required></textarea>
			    	</div>
			    </div>
			    <div class="form-row">
		            <div class="form-group col-md-12 col-sm-12">
		                <label>Tipo</label>
		                <select name="type" class="form-control" id="type" required>
		                </select>
		            </div>
	            </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button data-dismiss="modal" id="update" type="button" class="btn btn-info">Actualizar</button>
	        	<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
	      	</div>
	    </div>
  	</div>
</div>
@endsection

@section('script')
	<script>
	    $(document).ready(function() 
	    {
    	@foreach($user->councils as $council)
    		@if($user->getCurrentRol()->id===$council->pivot->role_id)
	    		@foreach($council->diaries->sortByDesc("event_date") as $diary)
	    			@foreach($diary->points->sortByDesc("created_at") as $key => $point)
	    				@if($point->user_id==$user->id)
				    		$("#get-data-{{$point->id}}").click(function() 
					    	{
					    		var route = "/punto/editar/"+$(this).val();

				                $.get(route,{"_token":"{{csrf_token()}}"},function (data) 
				                {
				                    $("#id").val(data.id);
				                    $("#description").val(data.description);

				                    $("#type").empty();

				                    var type=data.type;

				                    if(type=="info")
				                    {
				                    	$("#type").append('<option value="info">Información</option>');
				                    	$("#type").append('<option value="decision">Decisión</option>');
				                    }
				                    else
				                    {	
				                    	$("#type").append('<option value="decision">Decisión</option>');
				                		$("#type").append('<option value="info">Información</option>');
				                    }

				                });
							});
	    				@endif
    				@endforeach
				@endforeach
			@endif
		@endforeach

	    	$("#update").click(function() 
	    	{
                $.post("{{route("update_point")}}", 
                {
                    "_token": "{{csrf_token()}}",
                    "id": $("#id").val(),
                    "description": $("#description").val(),
                    "type": $("#type").val(),
                }, 
                function (data) 
                {           
                    $("#description-"+data.update.id).text(data.update.description);

                    var type;

                    if(data.update.type=="info")
                    {
                    	type="(Punto de información)";
                    }
                    else
                    {
                    	type="(Punto de decisión)";
                    }

                    $("#type-"+data.update.id).text(type);
                });
			});
	    });
	</script>
<br>
@endsection