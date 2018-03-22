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
	   		<label for="description">Descripción de Agenda</label>
	    	<textarea name="description" class="form-control" id="description" rows="3" required></textarea>
	    </div>
			
		<br>

		<!-- Aqui el codigo de los puntos-->
		<div class="justify-content-center text-center">
            <button id="btn-add" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Punto</button>
        </div>

        <br>
        <div id="inputPoints"></div>

		<br>
		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary ">Registrar</button>
	  	</div>
	</form>
</div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var inputPoints = $("#inputPoints");
            var i=0;
            
            $("#btn-add").click(function() {
                i++;
                addNew();
            });

            function addNew() {
                inputPoints.append('<div style="margin-bottom:50px; background:#EEEEEE; border-radius: 10px;" class="point-'+i+'"><h4 class="text-center font-weight-normal">Punto</h4><div class="justify-content-center text-center"><button value="'+i+'" type="button" id="remove-point-'+i+'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-9"><label>Descripción del Punto</label><textarea name="description[]" class="form-control" id="description" rows="3" required></textarea></div><div class="col-xs-12 col-sm-3"><label>Tipo</label><select name="type[]" class="form-control" required><option value="Información">Información</option><option value="Decisión">Decisión</option></select></div></div></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6"><br><div class="custom-file"><input name="attached_document[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 1 .pdf</label></div></div><div class="col-xs-12 col-sm-6"><br><div class="custom-file"><input name="attached_document[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 2 .pdf</label></div></div></div></div> <div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6"><br><div class="custom-file"><input name="attached_document[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 3 .pdf</label></div></div><div class="col-xs-12 col-sm-6" style="margin-bottom:25px;"><br><div class="custom-file"><input name="attached_document[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 4 .pdf</label></div></div></div></div></div>');

	            $("#remove-point-"+i).click(function(event) {
	                $(".point-"+$(this).val()).remove();
	            });
            }
        });
    </script>
@endsection
