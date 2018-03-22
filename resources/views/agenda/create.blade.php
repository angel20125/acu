@extends('layouts.home')

@section('title' , "Registrar Agenda")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-md-10 col-sm-12 " action="{{route("admin_agendas_create")}}" method="post" enctype="multipart/form-data">
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
		<h1 class="text-center font-weight-normal">Registrar Agenda</h1>
		<br><br>
  	

		<div class="form-group">
	   		<label for="description">Descripción</label>
	    	<textarea name="description" class="form-control" id="description" rows="3" required></textarea>
	    </div>
			
		<br>

		<!-- Aqui el codigo de los puntos-->


		<br>
		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary ">Registrar</button>
	  	</div>
	</form>
</div>

@endsection
