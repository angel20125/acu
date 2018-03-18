<header >
	<nav class="navbar navbar-expand-md navbar-dark top-fixed bg-dark justify-content-between">
	<a class="navbar-brand" href="#">ACU</a>
		
  
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
  	</button>
  	
	<div class="collapse navbar-collapse item-rg  d-md-none d-lg-none" id="navbarsExampleDefault">
		<div class=" d-flex justify-content-center  align-items-center px-3 item-rg nav-pills nav-fill" >
			<ul class="nav flex-column mr-sm-2  " style="margin-right: 2rem !important">
				<li class="nav-item">
					<a class="nav-item"  href="{{route("logout")}}">
						<i class="far fa-bell float-right" data-toggle="tooltip" data-placement="aria-label" title="Notificaciones" ></i>
					</a>	
				</li>
			</ul>
			<ul class="nav flex-column mr-sm-2" style="margin-left: 2rem !important">
				<li class="nav-item">
					<a class="nav-item " href="{{route("logout")}}">
						<i class="fas fa-sign-out-alt" data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesión"></i>
					</a>
				</li>
			</ul>
		</div>
		
		<div class="d-lg-none d-md-none">
			@include("includes.menu_".$user->getCurrentRol()->name)
		</div>
	</div>
</nav>
</header>

