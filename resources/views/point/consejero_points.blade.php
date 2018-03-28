@extends('layouts.home')

@if($user->getCurrentRol()->name=="consejero") 
    @section('title' , "Presentar Puntos")
@else 
    @section('title' , "Agregar Puntos")
@endif 


@section('links')
<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-lg-10 col-md-12 col-sm-12" @if($user->getCurrentRol()->name=="consejero") action="{{route("consejero_propose_points")}}" @elseif($user->getCurrentRol()->name=="presidente") action="{{route("presidente_propose_points")}}" @else action="{{route("adjunto_propose_points")}}" @endif method="post" enctype="multipart/form-data">
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
		<h1 class="text-center font-weight-normal">@if($user->getCurrentRol()->name=="consejero") Presentar Puntos @else Agregar Puntos @endif</h1>
		<br>
  		
        <div class="form-row">
            <div class="form-group col-md-12 col-sm-12">
                <label>Agenda</label>
                <select name="diary_id" class="form-control" id="diary_id" required>
                    @foreach($user->councils as $council)
                        @if($user->getCurrentRol()->id===$council->pivot->role_id)
                            @foreach($council->diaries->where("limit_date",">",gmdate("Y-m-d")) as $diary)
                                <option value="{{$diary->id}}">{{$council->name." - ".\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
			
		<br>
	 	<div id="inputPoints"></div>

		<!-- Aqui el codigo de los puntos-->
		<div class="justify-content-center text-center">
            <button id="btn-add" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Punto</button>
        </div>

        <br>
       
		<div class="justify-content-center text-center">
	  		<button type="submit" class="btn btn-primary" id="presentar">@if($user->getCurrentRol()->name=="consejero") Presentar @else Agregar @endif</button>
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
                inputPoints.append('<div style="margin-bottom:50px; background:#f8f9fa; border-radius: 10px;" class="point-'+i+'"><div class="container-fluid"><div class="row justify-content-between" style="padding-left: 12px; padding-right: 2px"><h3 class="text-center font-weight-normal" >Punto</h3><button value="'+i+'" type="button" id="remove-point-'+i+'" class="btn btn-danger"  data-placement="left" title="Eliminar Punto"><i class="fa fa-trash text-right" aria-hidden="true" ></i></div><div class="row"><div class="col-xs-12 col-sm-9"><label>Descripción del Punto</label><textarea name="description_point[]" class="form-control" id="description" rows="3" required></textarea></div><div class="col-xs-12 col-sm-3"><label>Tipo</label><select name="type[]" class="form-control" required><option value="info">Información</option><option value="decision">Decisión</option></select></div></div></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_one[]"  accept=" .pdf" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file" >Documento de soporte 1 .pdf</label></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_two[]"  accept=" .pdf" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 2 .pdf</label></div></div></div></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_three[]" accept=" .pdf" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 3 .pdf</label></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" style="margin-bottom:25px;"><br><div class="custom-file"><input name="attached_document_four[]" accept=" .pdf" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 4 .pdf</label></div></div></div></div></div>');

                $(function () {
		 			 $('[data-toggle="tooltip"]').tooltip()
				});

	            $("#remove-point-"+i).click(function(event) {
	                $(".point-"+$(this).val()).remove();
	            });
            }
        });
    </script>
@endsection
