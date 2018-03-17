<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="favicon.ico">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<title>@yield('title') - ACU</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<!-- Custom styles for this template -->
	
	<link href="{{ asset('css/sticky.css') }}" rel="stylesheet">
	<link href="{{ asset('css/side.css') }}" rel="stylesheet">
</head>

<body>

<header>
	<!-- Barra de navegacion fija -->
 	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark justify-content-between">
		<a class="navbar-brand" href="#">ACU</a>
		
				
					<a class="nav-link  " href="{{route("logout")}}">
				<span data-feather="log-out"></span>
				
			</a>
			
		
		 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="true" aria-label="Toggle navigation">
	 			<span class="navbar-toggler-icon"></span>

		</button>

	</nav>
		
	<div class="pos-f-t">

		<div class="collapse" id="navbarToggleExternalContent">
			@include("includes.menu_".$user->getCurrentRol()->name)
		</div>
	</div>
</header>

<div class="container-fluid">
	<div class="row">
		<!-- SideBar -->
		<nav class="col-md-2 d-none d-md-block bg-light sidebar border-right" > 
			@include("includes.menu_".$user->getCurrentRol()->name)
		</nav>
		<!-- Contenido de pagina -->
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4" style="marginto">
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
	<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
	<script>
	  feather.replace()
  </script>
</body>
</html>