@extends('layouts.home')

@section('title' , "Editar Agenda")

@section('links')
    <link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
    <form class="form-signin col-md-10 col-sm-12 " action="{{route("admin_agendas_update")}}" method="post" enctype="multipart/form-data">
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
        <h1 class="text-center font-weight-normal">Editar Agenda</h1>
        <br><br>
    
        <input type="hidden" name="agenda_id" value="{{$agenda->id}}"/>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" id="description" rows="3" required>{{$agenda->description}}</textarea>
        </div>
        <div class="form-row form-group">
            <div class="form-group col-md-6 col-sm-12">
                <label for="status_input">Estado</label>
                <select name="status" class="form-control" id="status" required>
                    <option {{$agenda->status=="1"?"selected":""}} value="1">A tratar</option>
                    <option {{$agenda->status=="2"?"selected":""}} value="2">Tratada</option>
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="load_file_input">Reemplazar Archivo</label>
                <div class="custom-file">
                    <input name="attached_document" type="file" class="custom-file-input" id="load_file" lang="es">
                    <label class="custom-file-label" for="load_file">Seleccione un archivo .pdf</label>
                </div>
            </div>
        </div>
        @if(file_exists("docs/".$agenda->attached_document))

            <div class="justify-content-center text-center">
                <button type="submit" class="btn btn-primary " href="{{asset("docs/".$agenda->attached_document)}}">Archivo .pdf actual</button>
            </div>
        @endif
        <div class="form-row justify-content-center">
            <div class="form-group col-md-6 col-sm-10">
                <label for="date_input">Fecha</label>
                <input name="event_date" type="date" class="form-control" id="date_input" value="{{$agenda->event_date}}">
            </div>
         </div>
        <br>
        <div class="justify-content-center text-center">
            <button type="submit" class="btn btn-primary ">Guardar</button>
            <br>
            <a href="{{route("admin_agendas")}}"><br>Ver Agendas</a>
        </div>
    </form>
</div>

@endsection

