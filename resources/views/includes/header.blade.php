<header class="navbar navbar-expand-md navbar-dark  bg-dark bd-navbar justify-content-between">

		<a class="navbar-brand" href="{{ route('dashboard') }}">
			<img src="{{ asset('img/icon_uneg_white.png') }}" width="25"" alt="">
			ACU
		</a>


	<button class="navbar-toggler"  type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
  	</button>

	<div class="collapse navbar-collapse item-rg  d-md-none bd-navba d-lg-none " id="navbarsExampleDefault">

		<div class=" d-flex justify-content-center  align-items-center px-3 item-rg nav-pills nav-fill" >
			<div class="dropdown show" id="markasread" onClick="markNotificationAsRead('{{count(auth()->user()->unreadNotifications)}}')">
			  	<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    	@if(count($user->unreadNotifications)>0) <i style="color:red;" class="fas fa-bell"></i >@else <i class="fas fa-bell"></i> @endif<span class="badge">{{count($user->unreadNotifications)}}</span>
			  	</a>

			  	<div class="dropdown-menu scrollable-menu " aria-labelledby="dropdownMenuLink">
					@forelse($user->notifications as $notification)
						@include('includes.notification.'.snake_case(class_basename($notification->type)))
						<div class="dropdown-divider"></div>
						@empty
						<a class="dropdown-item dropdown-item-menu text-center" href="#">No tienes notificaciones.</a>
					@endforelse
			 	</div>
			</div>

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
