<header class="navbar navbar-expand-md navbar-dark  bg-dark bd-navbar justify-content-between">

		<a class="navbar-brand" href="{{ route('dashboard') }}">
			<img src="{{ asset('img/icon_uneg_white.png') }}" width="25"" alt="">
			ACU
		</a>


	<button class="navbar-toggler"  type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
  	</button>

	<div class="collapse navbar-collapse item-rg  d-md-none bd-navba d-lg-none " id="navbarsExampleDefault">
		<ul>
			<li class="dropdown" id="markasread" onClick="markNotificationAsRead('{{count(auth()->user()->unreadNotifications)}}')">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="glyphicon glyphicon-globe"></span> Notificaciones <span class="badge">{{count(auth()->user()->unreadNotifications)}}</span>
						</a>

						<ul class="dropdown-menu" role="menu">
							@forelse(auth()->user()->unreadNotifications as $notification)
								@include('includes.notification.'.snake_case(class_basename($notification->type)))
								@empty
									<a href="#">No hay notificaciones no leídas</a>
							@endforelse

						</ul>
			</li>
		</ul>

		<div class=" d-flex justify-content-center  align-items-center px-3 item-rg nav-pills nav-fill" >
			<ul class="nav flex-column mr-sm-2  ">
				<li class="nav-item" data-toggle="tooltip" data-placement="bottom" title="Notificaciones">
					<a class="tette float-right"  href="#" >
						<i class=" far fa-bell"></i>
					</a>
				</li>
			</ul>







			<ul class="nav flex-column mr-sm-2" style="margin-left: 2rem !important">
				<li class="nav-item"  data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesión">
					<a class=" tette " href="{{route("logout")}}">
						<i class="fas fa-sign-out-alt"></i>
					</a>
				</li>
			</ul>
		</div>

		<div class="d-lg-none d-md-none tette">
			@include("includes.menu_".$user->getCurrentRol()->name)
		</div>
	</div>

</header>
