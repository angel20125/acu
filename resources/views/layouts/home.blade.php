<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

	<title>@yield('title') - ACU</title>
	
	<!-- Custom styles for this template -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/sticky.css') }}" rel="stylesheet">
	<link href="{{ asset('css/side.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/pace-theme-minimal.css') }}">
	<script src="{{ asset('js/pace.min.js') }}"></script>
	<link href="{{ asset('css/fa-svg-with-js.css') }}" rel="stylesheet">
	@yield('links')
</head>

<body>
	<!-- Barra de navegacion fija -->
	@include("includes.header")
		<!-- SideBar -->
<div class="container-fluid">
	<div class="row flex-xl-nowrap">
		<div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar border-right sidebar-sticky bd-sidebar" > 
			@include("includes.menu_".$user->getCurrentRol()->name)
		</div>

		<!-- Contenido de pagina  -->
		<main  class="col-md-9 ml-sm-auto col-lg-10  py-md-3 bd-content" role="main">
			@yield('content')
		</main>
	</div>
</div>

@if($user->getCurrentRol()->name!="admin" || $user->getCurrentRol()->name!="secretaria")
<div id="my-statistics" class="modal fade" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header" style="background:#eceff1;">
	        	<h5 class="modal-title">Mi Perfil</h5>
	      	</div>
	      	<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md-12 col-sm-12">
		   				<h6 class="card-subtitle mb-2 text-muted" style="text-align: center;">Hola {{$user->first_name}}, aquí encontrarás información relevante, desde que formas parte de nuestra familia ACU...</h6>
			    	</div>
					<div class="form-group col-md-6 col-sm-12">
						<div class="card">
						  	<ul class="list-group list-group-flush">
						    	<li style="background:#5c6bc0; color: white;" class="list-group-item">Puntos incluidos: {{$user->points->where("pre_status","incluido")->count()}}</li>
						    	<li style="background:#ffd54f; color: black;" class="list-group-item">Puntos desglosados: {{$user->points->where("pre_status","desglosado")->count()}}</li>
						    	<li style="background:#66bb6a; color: black;" class="list-group-item">Puntos aprobados:{{$user->points->where("post_status","aprobado")->count()}}</li>
						    	<li style="background:#ef5350; color: white;" class="list-group-item">Puntos rechazados: {{$user->points->where("post_status","rechazado")->count()}}</li>
						  	</ul>
						</div>
			    	</div>
					<div class="form-group col-md-6 col-sm-12">
						<div class="card">
						  	<ul class="list-group list-group-flush">
						    	<li style="background:#78909c; color: white;" class="list-group-item">Puntos diferidos: {{$user->points->where("post_status","diferido")->count()}}</li>
						    	<li style="background:#78909c; color: white;" class="list-group-item">Puntos retirados: {{$user->points->where("post_status","retirado")->count()}}</li>
						    	<li style="background:#78909c; color: white;" class="list-group-item">Puntos presentados: {{$user->points->where("post_status","presentado")->count()}}</li>
						    	<li style="background:#78909c; color: white;" class="list-group-item">Pts no presentados: {{$user->points->where("post_status","no_presentado")->count()}}</li>
						  	</ul>
						</div>
			    	</div>
					<div class="form-group col-md-12 col-sm-12">
						<div class="card">
						  	<ul class="list-group list-group-flush">
						    	<li style="background:#eceff1; color: black;" class="list-group-item">Historial de Roles</li>
						  		@foreach($user->transactions->sortByDesc("start_date") as $trans)
						  			@if($trans->type=="create_user_consejero")
						  				@if($trans->end_date)
						    				<li class="list-group-item"><b>Consejero</b> del {{$user->councils()->where("id",$trans->affected_id)->first()->name}} desde el {{DateTime::createFromFormat("Y-m-d",$trans->start_date)->format("d/m/Y")}} hasta el {{DateTime::createFromFormat("Y-m-d",$trans->end_date)->format("d/m/Y")}}.</li>
						    			@else
						    				<li class="list-group-item"><b>Consejero</b> del {{$user->councils()->where("id",$trans->affected_id)->first()->name}} desde el {{DateTime::createFromFormat("Y-m-d",$trans->start_date)->format("d/m/Y")}} hasta la actualidad.</li>
						    			@endif
						    		@elseif($trans->type=="create_user_adjunto")
					  					@if($trans->end_date)
						    				<li class="list-group-item"><b>Adjunto</b> del {{$user->councils()->where("id",$trans->affected_id)->first()->name}} desde el {{DateTime::createFromFormat("Y-m-d",$trans->start_date)->format("d/m/Y")}} hasta el {{DateTime::createFromFormat("Y-m-d",$trans->end_date)->format("d/m/Y")}}.</li>
						    			@else
						    				<li class="list-group-item"><b>Adjunto</b> del {{$user->councils()->where("id",$trans->affected_id)->first()->name}} desde el {{DateTime::createFromFormat("Y-m-d",$trans->start_date)->format("d/m/Y")}} hasta la actualidad.</li>
						    			@endif
						    		@elseif($trans->type=="create_user_presidente")
					  					@if($trans->end_date)
						    				<li class="list-group-item"><b>Presidente</b> del {{$user->councils()->where("id",$trans->affected_id)->first()->name}} desde el {{DateTime::createFromFormat("Y-m-d",$trans->start_date)->format("d/m/Y")}} hasta el {{DateTime::createFromFormat("Y-m-d",$trans->end_date)->format("d/m/Y")}}.</li>
						    			@else
						    				<li class="list-group-item"><b>Presidente</b> del {{$user->councils()->where("id",$trans->affected_id)->first()->name}} desde el {{DateTime::createFromFormat("Y-m-d",$trans->start_date)->format("d/m/Y")}} hasta la actualidad.</li>
						    			@endif
						    		@endif
						    	@endforeach
						  	</ul>
						</div>
			    	</div>
			    </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
	      	</div>
	    </div>
  	</div>
</div>

<div id="my-councils" class="modal fade" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div style="background:#eceff1;" class="modal-header">
	        	<h5 class="modal-title">Mis Consejos</h5>
	      	</div>
	      	<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md-12 col-sm-12">
			   			<h6 class="card-subtitle mb-2 text-muted" style="text-align: center;">Hola {{$user->first_name}}, aquí encontrarás los consejos donde participas actualmente con su respectivo rol.</h6>
			    	</div>
					<div class="form-group col-md-12 col-sm-12">
						<div class="card">
						  	<ul class="list-group list-group-flush">
	  			    	    	@foreach($user->councils->sortBy("name") as $council)
						    		<li style="text-align: center; background:#eceff1;" class="list-group-item">{{$council->name}} - <b>{{$user->roles()->where("id",$council->pivot->role_id)->first()->display_name}}</b></li>
					    	   	@endforeach
						  	</ul>
						</div>
			    	</div>
			    </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
	      	</div>
	    </div>
  	</div>
</div>
@endif

<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
		
	<script  src="{{ asset('js/jquery-3.3.1.js') }}" ></script>
	<script  src="{{ asset('js/popper.min.js') }}" ></script>
	<script  src="{{ asset('js/bootstrap.min.js') }} " ></script>
	
	<!-- Icons -->
	<script  src="{{ asset('js/fontawesome-all.min.js') }}" ></script>

	<script type="text/javascript">
		$(function () {
 			 $('[data-toggle="tooltip"]').tooltip()
		});
	</script>
	
	@yield('script')
</body>
</html>