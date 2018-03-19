@extends('layouts.home')

@section('title' , "Editar consejo")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')


@if($errors->any())
	@foreach ($errors->all() as $error)
        {{$error}}
	@endforeach
@endif

@if(session('message_info'))
    {{session('message_info')}}
@endif

<div class="row justify-content-center">
	<form class="form-signin col-lg-8 col-md-10 col-sm-12" action="{{route("admin_councils_update")}}" method="post" enctype="multipart/form-data"">
		@csrf
		<h1 class="text-center mr1 font-weight-normal">Confirmar Nombre</h1>
		<br><br>
		<div class="form-group col-10 offset-1">
	      	<label for="firstname_input">Nombre</label>
			<div class="input-group mb-3">
				<input type="hidden" name="council_id" value="{{$council->id}}"/>
			  	<input name="name" type="text" id="name" class="form-control" aria-label="Nombre" aria-describedby="basic-addon1" value="{{$council->name}}" required autofocus >
			</div>
    	</div>
		<div class="justify-content-center text-center">
  			<button type="submit" class="btn btn-primary ">Guardar</button>
		</div>
	</form>
</div>

@endsection
