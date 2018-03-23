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
	<main  class="col-md-9 ml-sm-auto col-lg-10  py-md-3 pl-md-5 bd-content" role="main">
		@yield('content')
	</main>
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
		})
	</script>
	
	@yield('script')
</body>
</html>