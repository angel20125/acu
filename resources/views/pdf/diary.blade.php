<div class="card">
	<div class="card-body" style="text-align: center;">
    	<h2 class="card-title">{{$diary->council->name}}</h2>
    	<h5 class="card-subtitle mb-2 text-muted">Descripción de la agenda</h5>
    	<p id="diary-description" style="font-style: oblique;" class="card-text">{{$diary->description}}</p>
    	<p id="diary-info"class="card-text"><b>Lugar:</b> {{$diary->place}} <b>Fecha:</b> {{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}} <b>Estado:</b> @if($current_date <= $diary->event_date) {{$diary->status=="0"?"Pre-Agenda":"Post-Agenda"}} @elseif($current_date > $diary->event_date && $diary->status==0) Pre-Agenda (En espera de que el adjunto la finalice) @else Post-Agenda @endif</p>
    	
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
		  			<h3 class="card-title">Presentado por el/la {{$point->user->position->name}} "{{$point->user->first_name}} {{$point->user->last_name}}" el día {{DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y")}}</h3>
		    		<h3 class="card-subtitle mb-2 text-muted">Descripción del punto</h3>
		    		<p id="description-{{$point->id}}" class="card-text">{{$point->description}}</p>
		    		<p id="type-{{$point->id}}">(Punto de {{$point->type=="info"?"información":"decisión"}})</p>

		    		@if($point->agreement)
		    			<h3 class="card-subtitle mb-2 text-muted">Acuerdo</h3>
		    			<p class="card-title">{{$point->agreement}}</p>
		    		@endif
		  		</div>
			</div>
    	@endforeach
 	</div>
</div>