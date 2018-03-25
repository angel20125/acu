@extends('layouts.home')

@section('title' , "Editar Consejo")

@section('links')
	<link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
	<form class="form-signin col-lg-8 col-md-10 col-sm-12" action="{{route("admin_councils_update")}}" method="post" enctype="multipart/form-data"">
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
		<h1 class="text-center mr1 font-weight-normal">Editar Consejo</h1>
		<br><br>
		<div class="form-group col-10 offset-1">
	      	<label for="name_input">Nombre</label>
			<div class="input-group mb-3">
				<input type="hidden" name="council_id" value="{{$council->id}}"/>
			  	<input name="name" type="text" id="name" class="form-control" aria-label="Nombre" aria-describedby="basic-addon1" value="{{$council->name}}" placeholder="Nombre del consejo" required autofocus >
			</div>
    	</div>

        <div class="form-row">
            @if(count($council->users)>0 && $council->president && $council->adjunto)
                <div class="form-group col-md-6 col-sm-12">
                    <label for="president_id">Presidente</label>
                    <select name="president_id" class="form-control" id="president_id" required>
                        @foreach($council->users as $member)
                            @if($member->id!=$council->adjunto->id)
                                <option {{$member->id==$council->president->id?"selected":""}} value="{{$member->id}}">{{$member->first_name}} {{$member->last_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="adjunto_id">Adjunto</label>
                    <select name="adjunto_id" class="form-control" id="adjunto_id" required>
                        @foreach($council->users as $member)
                            @if($member->id!=$council->president->id)
                                <option {{$member->id==$council->adjunto->id?"selected":""}} value="{{$member->id}}">{{$member->first_name}} {{$member->last_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

		<div class="justify-content-center text-center">
  			<button type="submit" class="btn btn-primary ">Guardar</button>
		</div>
        <div class="justify-content-center text-center">
            <a href="{{route("admin_councils")}}"><br>Ver Consejos</a>
        </div>

        @if(count($council->users)>0 && !$council->president)
            <br>
            <div style="text-align:center;" class="alert alert-primary" role="alert">
                <b>Nota:</b> Necesita registrar o asignar un usuario <b>Presidente</b> para poder cambiar los cargos
            </div>
        @elseif(count($council->users)>0 && !$council->adjunto)
            <br>
            <div style="text-align:center;" class="alert alert-primary" role="alert">
                <b>Nota:</b> Necesita registrar o asignar un usuario <b>Adjunto</b> para poder cambiar los cargos
            </div> 
        @elseif(count($council->users)>0 && !$council->president && !$council->adjunto) 
            <br>
            <div style="text-align:center;" class="alert alert-primary" role="alert">
                <b>Nota:</b> Recuerde registrar o asignar un usuario <b>Presidente</b> y un <b>Adjunto</b> para el {{$council->name}}
            </div> 
        @endif
	</form>
</div>

@endsection
