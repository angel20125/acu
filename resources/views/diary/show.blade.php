@extends('layouts.home')

@section('title' , "Mostrar Agenda")

@section('content')

<div class="card">
	<div class="card-body" style="text-align: center;">
    	<h2 class="card-title">{{$diary->council->name}}</h2>
    	<h5 class="card-subtitle mb-2 text-muted">Descripción de la agenda</h5>
    	<p id="diary-description" style="font-style: oblique;" class="card-text">{{$diary->description}}</p>
    	<p id="diary-info"class="card-text"><b>Lugar:</b> {{$diary->place}} <b>Fecha:</b> {{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}} <b>Estado:</b> @if(gmdate("Y-m-d") <= $diary->event_date) {{$diary->status=="0"?"Pre-Agenda":"Post-Agenda"}} @elseif(gmdate("Y-m-d") > $diary->event_date && $diary->status==0) Pre-Agenda (En espera de que el adjunto la finalice) @else Post-Agenda @endif</p>

    	@if((($diary->status==0 && $diary->council->president && $diary->council->president->id==$user->id) || ($diary->status==0 && $diary->council->adjunto && $diary->council->adjunto->id==$user->id) || ($user->getCurrentRol()->name=="admin")) && gmdate("Y-m-d") <= $diary->event_date)
			<button data-toggle="modal" data-target="#edit-diary" id="get-data" type="button" value="{{$diary->id}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></button>
			<a class="btn btn-danger" href="{{route("delete_diary",["diary_id"=>$diary->id])}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
		@endif

		<a class="btn btn-info" href="{{route("diary_pdf",["diary_id"=>$diary->id])}}"><i class="fa fa-print" aria-hidden="true"></i></a>
    	
    	<br>

    	@foreach($diary->points->where("pre_status","incluido")->sortByDesc("created_at") as $key => $point)
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
		    		<p class="card-text">{{$point->description}}</p>
		    		<p>(Punto de {{$point->type=="info"?"información":"decisión"}})</p>

		    		@if($point->agreement)
		    			<h5 class="card-subtitle mb-2 text-muted">Acuerdo</h5>
		    			<h6 class="card-title">{{$point->agreement}}</h6>
		    		@endif

		    		@if(count($point->documents)>0)
		    			<br>
	    				<h5 class="card-subtitle mb-2 text-muted">Documentos de soporte</h5>
	    				<br>
		    		@endif
		    		<div class="row justify-content-center">
		    		@foreach($point->documents as $k => $document)
		    			@if(file_exists("docs/".$document->direction))
		    			
		    				<div class="col-lg-2 col-md-5 col-sm-4 mra">
		    				<a target="_blank" href="{{asset("docs/".$document->direction)}}" class="btn btn-success">Documento {{$k+1}}</a>
		    				</div>
	    				
		    			@endif
		    		@endforeach
		    		</div>
		  		</div>
			</div>
    	@endforeach
 	</div>
</div>
<br>

<div id="edit-diary" class="modal fade" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title">Editar Agenda</h5>
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
		            <div class="form-group col-md-5 col-sm-12">
			    		<label for="event_date">Fecha a tratar</label>
			    		<input name="event_date" type="date" class="form-control" id="event_date" required>
		            </div>
		            <div class="form-group col-md-7 col-sm-12">
		                <label>Lugar</label>
            			<input name="place" type="text" class="form-control" placeholder="Lugar donde se tratará la agenda" id="place" required>
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
    		$("#get-data").click(function() 
	    	{
	    		var route = "/agenda/editar/"+$(this).val();

                $.get(route,{"_token":"{{csrf_token()}}"},function (data) 
                {
                    $("#id").val(data.id);
                    $("#description").val(data.description);
                    $("#event_date").val(data.event_date);
                    $("#place").val(data.place);
                });
			});

	    	$("#update").click(function() 
	    	{
                $.post("{{route("update_diary")}}", 
                {
                    "_token": "{{csrf_token()}}",
                    "id": $("#id").val(),
                    "description": $("#description").val(),
                    "event_date": $("#event_date").val(),
                    "place": $("#place").val(),
                }, 
                function (data) 
                {
                	if(data.update==0) 
                	{
                		alert("No puede cambiar la fecha de la agenda a una fecha pasada");
                	}
                	else if(data.update==1)
                	{
                		alert("El presidente o adjunto del {{$diary->council->name}} ya registró una nueva agenda para el día seleccionado por usted, por favor seleccione otro día");
                	}
                	else
                	{
	                    $("#diary-description").text(data.update.description);
	                    $("#diary-info").empty();

	                    $("#diary-info").append("<b>Lugar:</b> "+data.update.place+" <b>Fecha:</b> "+data.update.event_date+" <b>Estado:</b> Pre-Agenda");
                	}
                });
			});
	    });
	</script>
<br>
@endsection