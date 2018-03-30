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

<div id="my-councils" class="modal fade" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title">Mis Consejos</h5>
	      	</div>
	      	<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md-12 col-sm-12">
			   			<h6 class="card-subtitle mb-2 text-muted" style="text-align: center;">Aquí puedes visualizar los consejos donde participas y tienes los privilegios de poder presentar o agregar puntos a las pre-agendas, registrar pre-agendas, entre otras funciones más, según el rol que tengas dentro del consejo.</h6>
			    	</div>
	    	    	@foreach($user->councils->sortBy("name") as $council)
					<div class="form-group col-md-12 col-sm-12">
		   				<p style="text-align: center;">{{$council->name}} - {{$user->roles()->where("id",$council->pivot->role_id)->first()->display_name}}</p>
			    	</div>
	    	    	@endforeach
			    </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
	      	</div>
	    </div>
  	</div>
</div>

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