
@extends('layouts.home')

@section('title' , "Registrar Agenda")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-md-10 col-sm-12 " action="#" method="post" enctype="multipart/form-data">
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
		<h1 class="text-center font-weight-normal">Registrar reunión</h1>
		<br><br>
  	
		<div class="form-row justify-content-center">
			<div class="form-group col-md-8 col-sm-10">
			    <label for="date_input">Fecha</label>
			    <input name="date" type="date" class="form-control" id="date">
			</div>
			<div class="form-group col-md-4 col-sm-10">
			    <label for="president_input">Presidente</label>
				<div class="input-group mb-3">
			    	<input name="president" type="text" id="president" class="form-control" plac.com" aria-label="president" aria-describedby="basic-addon1" disabled value="Victor Leon">
				</div>
			</div>
		</div>
		
		<br>

		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary ">Registrar</button>
	  	</div>
	</form>
</div>

@endsection