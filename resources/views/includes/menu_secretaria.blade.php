<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted "  >
	<i class="fas fa-home"></i> <a class=" nav-link" href="{{route("dashboard")}}">Inicio</a>
</h6>

@if(Session::has('impersonated_by'))
	<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted "  >
		<i class="fa fa-arrow-circle-left"></i> <a class="nav-link active" href="{{route("user_regenerate")}}">Volver a admin</a>
	</h6>
@endif

<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="far fa-user"></i> <span class="mr8">SESIÓN {{$user->getCurrentRol()->display_name}}</span>
</h6>

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link  " href="#">
			{{$user->first_name}} {{$user->last_name}}
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  " href="{{route("profile")}}">
			Editar Perfil  
		</a>
	</li>
</ul>

<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="fas fa-handshake"></i> <span class="mr8">CARGO AUTORIZANTE</span>
</h6>

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link" href="#">{{$user->positionBoss->name}}</a>
	</li>
</ul>

<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="fas fa-sitemap"></i><span class="mr8">CONSEJOS</span>
</h6>

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link  " href="{{route("councils")}}">
			Ver Consejos
		</a>
	</li>
</ul>

<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="fas fa-users"></i><span class="mr8">MIEMBROS</span>
</h6>

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link  " href="{{route("users")}}">
			Ver Miembros
		</a>
	</li>
</ul>

<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="far fa-calendar-alt"></i><span class="mr8">AGENDAS</span> 
</h6>

<ul class="nav flex-column">
	<li class="nav-item-active">
		<a class="nav-link  " href="{{route("diaries")}}">
			Ver Agendas
		</a>
	</li>
	<li class="nav-item-active">
		<a class="nav-link  " href="{{route("secretaria_propose_points")}}">
			Agregar/Presentar Puntos
		</a>
	</li>
</ul>

@if($user->hasRole("adjunto") || $user->hasRole("consejero") || $user->hasRole("presidente"))
	<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted  ">
		<i class="fas fa-address-card"></i><span class="mr8">ROLES</span>
	</h6>

	<ul class="nav flex-column ">
		@if($user->hasRole("adjunto"))
			<li class="nav-item">
				<a class="nav-link " href="{{route("change_rol",["rol_name"=>"adjunto"])}}">
					Adjunto
				</a>
			</li>
		@endif
		@if($user->hasRole("consejero"))
			<li class="nav-item">
				<a class="nav-link " href="{{route("change_rol",["rol_name"=>"consejero"])}}">
					Consejero
				</a>
			</li>
		@endif
		@if($user->hasRole("presidente"))
			<li class="nav-item">
				<a class="nav-link " href="{{route("change_rol",["rol_name"=>"presidente"])}}">
					Presidente
				</a>
			</li>
		@endif
	</ul>
@endif

<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted  ">
	<i class="far fa-address-book"></i><span class="mr8">CONTACTO</span>
</h6>

<ul class="nav flex-column ">
	<li class="nav-item">
		<a class="nav-link " href="#">
			acu.uneg@gmail.com<br>+58 286-7137131
		</a>
	</li>
</ul>
