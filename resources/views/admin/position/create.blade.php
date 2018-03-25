@extends('layouts.home')

@section('title' , "Registrar Cargo")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-lg-8 col-md-10 col-sm-12" action="{{route("admin_positions_create")}}" method="post" enctype="multipart/form-data">
        @if($errors->any())
            <div style="text-align:center;" class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
        @endif
        @if(session('message_info'))
            <div style="text-align:center;" class="alert alert-success" role="alert">
                {{session('message_info')}}
            </div>
        @endif
		@csrf
		<h1 class="text-center mr1 font-weight-normal">Registrar Cargo</h1>
		<br><br>
		<div class="form-group col-md-10  offset-md-1 offset-sm-0">
	      	<label for="name_input">Nombre</label>
			<div class="input-group mb-3">
			  	<input name="name" type="text" id="name" class="form-control" placeholder="Cargo dentro de la universidad" aria-label="Nombre" aria-describedby="basic-addon1" required autofocus >
			</div>
    	</div>
		<div class="justify-content-center text-center">
  			<button type="submit" class="btn btn-primary ">Registrar</button>
		</div>
	</form>
</div>

@endsection
