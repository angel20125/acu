@extends('layouts.home')

@section('title' , "Editar Consejo")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-lg-8 col-md-10 col-sm-12" action="{{route("admin_councils_update")}}" method="post" enctype="multipart/form-data"">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
        @endif
        @if(session('message_info'))
            <div class="alert alert-success" role="alert">
                {{session('message_info')}}
            </div>
        @endif
		@csrf
		<h1 class="text-center mr1 font-weight-normal">Editar Consejo</h1>
		<br><br>
		<div class="form-group col-10 offset-1">
	      	<label for="name_input">Nombre</label>
			<div class="input-group mb-3">
				<input type="hidden" name="council_id" value="{{$council->id}}"/>
			  	<input name="name" type="text" id="name" class="form-control" aria-label="Nombre" aria-describedby="basic-addon1" value="{{$council->name}}" required autofocus >
			</div>
    	</div>
		<div class="justify-content-center text-center">
  			<button type="submit" class="btn btn-primary ">Guardar</button>
		</div>
        <div class="justify-content-center text-center">
            <a href="{{route("admin_councils")}}"><br>Ver Consejos</a>
        </div>
	</form>
</div>

@endsection
