@extends('layouts.home')

@section('title' , "Agregar/Presentar Puntos")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-lg-10 col-md-12 col-sm-12" action="{{route("secretaria_propose_points")}}" method="post" enctype="multipart/form-data">
        @if($errors->any())
        <br>
            <div style="text-align:center;" class="alert alert-danger" role="alert">
			  	{{$errors->first()}}
			</div>
        @endif
        @if(session('message_info'))
        <br>
			<div style="text-align:center;" class="alert alert-success" role="alert">
  				{{session('message_info')}}
			</div>
		@endif
		@csrf
		<h1 class="text-center font-weight-normal">Agregar/Presentar Puntos</h1>
        <h6 style="font-style: oblique;" class="text-center font-weight-normal">Cargo Institucional Autorizante - <b>{{$user->positionBoss->name}}</b></h6>
		<br>
  		
        <div class="form-row">
            <div class="form-group col-md-6 col-sm-12">
                <label for="user_id">Consejero</label>
                <select name="user_id" class="form-control" id="user_id" required>
                    <option value="none">Seleccione un consejero</option>
				    @foreach($members as $member)
				    	<option value="{{$member->id}}">{{$member->first_name}} {{$member->last_name}}</option>
				    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label>Agenda</label>
                <select name="diary_id" class="form-control" id="diary_id" required>
                    <option value="none">No disponible</option>
                </select>
            </div>
        </div>
			
		<br>
	 	<div id="inputPoints"></div>

		<!-- Aqui el codigo de los puntos-->
		<div class="justify-content-right text-right">
            <button id="btn-add" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Punto</button>
        </div>

        <br>
       
		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary" id="presentar" disabled>Agregar/Presentar</button>
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
                inputPoints.append('<div style="margin-bottom:50px; background:#f8f9fa; border-radius: 10px;" class="point-'+i+'"><div class="container-fluid"><div class="row justify-content-between" style="padding-left: 12px; padding-right: 2px"><h3 class="text-center font-weight-normal" >Punto</h3><button value="'+i+'" type="button" id="remove-point-'+i+'" class="btn btn-danger"  data-placement="left" title="Eliminar Punto"><i class="fa fa-trash text-right" aria-hidden="true" ></i></div><div class="row"><div class="col-xs-12 col-sm-9"><label>Descripción del Punto</label><textarea name="description_point[]" class="form-control" id="description" rows="3" required></textarea></div><div class="col-xs-12 col-sm-3"><label>Tipo</label><select name="type[]" class="form-control" required><option value="info">Información</option><option value="decision">Decisión</option></select></div></div></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input accept=" .pdf" name="attached_document_one[]" type="file" class="custom-file-input" id="load_file" lang="es" ><label class="custom-file-label" for="load_file" >Documento de soporte 1 .pdf</label></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_two[]" accept=" .pdf" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 2 .pdf</label></div></div></div></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_three[]" accept=" .pdf" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 3 .pdf</label></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" style="margin-bottom:25px;"><br><div class="custom-file"><input name="attached_document_four[]" accept=" .pdf" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 4 .pdf</label></div></div></div></div></div>');

                $(function () {
		 			 $('[data-toggle="tooltip"]').tooltip()
				});

	            $("#remove-point-"+i).click(function(event) {
	                $(".point-"+$(this).val()).remove();
	            });

                $(".custom-file-input").on('change', function() 
                { 
                    let fileName = $(this).val().split('\\').pop(); 
                    $(this).next(".custom-file-label").addClass("selected").html(fileName); 
                });
            }

            $("#user_id").change(function () {
                getData();           
            });

            function getData()
            {
                if($("#user_id").val()=="none")
                {
                    $("#presentar").prop("disabled",true);
                    $("#diary_id").empty();
                    $("#diary_id").append('<option value="none">No disponible</option>');
                }   
                else
                {
                    var route = "/secretaria/proponer_puntos/obtener/"+$("#user_id").val();
                    $.get(route,{"_token":"{{csrf_token()}}"}, 
                    function(data) 
                    {
                        $("#presentar").prop("disabled",false);
                        $("#diary_id").empty();

                        if(data.data[0]==null)
                        {
                            $("#presentar").prop("disabled",true);
                            $("#diary_id").empty();
                            $("#diary_id").append('<option value="none">No existen agendas disponibles</option>');
                        }
                        else
                        {  
                            $.each(data.data,function(key, value) 
                            {
                                $("#diary_id").append('<option value="'+value[0]+'">'+value[1]+'</option>');
                            }); 
                        }
                    });
                }
            }
        });
    </script>
@endsection
