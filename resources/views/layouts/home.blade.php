<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="favicon.ico">

	<title>@yield('title') - ACU</title>

	
	<!-- Custom styles for this template -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/sticky.css') }}" rel="stylesheet">
	<link href="{{ asset('css/side.css') }}" rel="stylesheet">
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
	<link href="{{ asset('css/fa-svg-with-js.css') }}" rel="stylesheet">
	@yield('links')
</head>

<body>


	<!-- Barra de navegacion fija -->
	@include("includes.header")
 	

<div class="container-fluid">
	
		<!-- SideBar -->
		<nav class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar border-right" > 
			<div class="sidebar-sticky">
				@include("includes.menu_".$user->getCurrentRol()->name)
			</div>
		</nav>
		<!-- Contenido de pagina  -->
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10   " style="marginto">
			@yield('content')
		</main>
	</div>
</div>

<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
		
	<script  src="{{ asset('js/jquery-3.3.1.js') }}" ></script>
	<script  src="{{ asset('js/bootstrap.min.js') }} " ></script>
	
	<script  src="{{ asset('js/popper.min.js') }}" ></script>

	<!-- Icons -->
	<script  src="{{ asset('js/fontawesome-all.min.js') }}" ></script>
	
	@yield('script')
</body>
</html>