@if($errors->any())
	@foreach ($errors->all() as $error)
        {{$error}}
	@endforeach
@endif

@if(session('message_info'))
    {{session('message_info')}}
@endif

<form action="{{route("admin_users_create")}}" method="post" enctype="multipart/form-data">
	@csrf
	<input type="text" name="identity_card" placeholder="Cédula de identidad">
	<input type="text" name="first_name" placeholder="Nombre">
	<input type="text" name="last_name" placeholder="Apellido">
	<input type="text" name="phone_number" placeholder="Número de teléfono">
	<input type="email" name="email" placeholder="Correo electrónico">
    <select name="council_id">
    	<optgroup label="Consejos">
	        @foreach($councils as $council)
	            <option value="{{$council->id}}">{{$council->name}}</option>
	        @endforeach
     	</optgroup>
    </select>
    <select name="rol">
    	<optgroup label="Roles">
	        @foreach($roles as $rol)
	        	@if($rol->name!="admin")
	            	<option value="{{$rol->name}}">{{$rol->display_name}}</option>
	            @endif
	        @endforeach
     	</optgroup>
    </select>
	<button class="btn btn-primary">Guardar</button>
</form>