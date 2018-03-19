<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="far fa-user"></i> <span class="mr8">USUARIO</span>
</h6>

<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link  " >
			{{$user->first_name}} {{$user->last_name}}  <br> ({{$user->getCurrentRol()->name}}) 
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  " href="">
			Editar Perfil  
		</a>
	</li>
	

</ul>

<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="far fa-calendar-alt"></i><span class="mr8">AGENDA</span> 
</h6>


<ul class="nav flex-column">
	<li class="nav-item-active">
		<a class="nav-link  " href="#">
			Ver Agendas
		</a>
	</li>

	
	<li class="nav-item">
		<a class="nav-link  " href="#">
			Agregar Punto
		</a>
	</li>
</ul>


<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="fas fa-sitemap"></i><span class="mr8">CONSEJOS</span>
</h6>


<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link  " href="{{route("admin_councils")}}">
			Ver Consejos
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  " href="{{route("admin_councils_create")}}">
			Registrar Consejo  
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  " href="{{route("admin_users")}}">
			Ver Usuarios
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  " href="{{route("admin_users_create")}}">
			Registrar Usuario  
		</a>
	</li>
</ul>


<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted">
	<i class="fas fa-users"></i><span class="mr8">REUNIONES</span>
</h6>


<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link  " href="{{route("dashboard")}}">
			Ver Reuniones
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  " href="#">
			Registrar Reunión
		</a>
	</li>

</ul>

	
<h6 class="sidebar-heading d-flex  align-items-center px-3 mt-3 mb-1 text-muted  ">
	<i class="far fa-address-book"></i><span class="mr8">CONTACTO</span>
</h6>
<ul class="nav flex-column ">
	<li class="nav-item">
		<a class="nav-link r" href="#">
			acu.uneg@gmail.com<br>+58 286-7137131
		</a>
	</li>
	
</ul>
