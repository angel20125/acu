@if($errors->any())
	@foreach ($errors->all() as $error)
        {{$error}}
	@endforeach
@endif

@if(session('message_info'))
    {{session('message_info')}}
@endif

<form action="{{route("admin_users_update")}}" method="post" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="user_id" value="{{$edit_user->id}}"/>
	<input type="text" name="identity_card" placeholder="Cédula de identidad" value="{{$edit_user->identity_card}}">
	<input type="text" name="first_name" placeholder="Nombre" value="{{$edit_user->first_name}}">
	<input type="text" name="last_name" placeholder="Apellido" value="{{$edit_user->last_name}}">
	<input type="text" name="phone_number" placeholder="Número de teléfono" value="{{$edit_user->phone_number}}">
	<input type="email" name="email" placeholder="Correo electrónico" value="{{$edit_user->email}}">
    <select name="council_id">
    	<optgroup label="Consejos">
            <option selected value="{{$currentCouncil->id}}">{{$currentCouncil->name}}</option>
     	</optgroup>
    </select>
    <select name="rol">
    	<optgroup label="Roles">
	        @foreach($roles as $rol)
	        	@if($rol->name!="admin")
	            	<option {{$edit_user->hasRole($rol->name)?"selected":""}} value="{{$rol->name}}">{{$rol->display_name}}</option>
	            @endif
	        @endforeach
     	</optgroup>
    </select>
    <select name="status">
    	<optgroup label="Estado">
            <option @if($edit_user->status==1) selected @endif value="1">Activo</option>
            <option @if($edit_user->status==0) selected @endif value="0">Inactivo</option>
     	</optgroup>
    </select>
	<button class="btn btn-primary">Guardar</button>
</form>