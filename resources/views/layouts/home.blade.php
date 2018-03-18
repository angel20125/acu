<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

	<title>@yield('title') - ACU</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<!-- Custom styles for this template -->
	
	<link href="{{ asset('css/sticky.css') }}" rel="stylesheet">
	<link href="{{ asset('css/side.css') }}" rel="stylesheet">
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
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10  px-4 " style="marginto">
			@yield('content')
		</main>
	</div>
</div>

<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

	<!-- Icons -->
	<script defer src="{{ asset('js/fontawesome-all.min.js') }}" ></script>x
</body>
</html>