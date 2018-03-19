@extends('layouts.home')

@section('title' , "Editar Agenda")

@section('links')
    <link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
    <form class="form-signin col-md-10 col-sm-12 " action="" method="post" enctype="multipart/form-data">
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
    

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
        </div>
        <div class="form-row form-group">
            <div class="form-group col-md-6 col-sm-12">
                <label for="council_id">Estado</label>
                <select name="council_id" class="form-control" id="council_id" >
                    
                        <option >a tratar</option>
                  
                    
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="phone_input">Cargar archivo</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="form-group col-md-6 col-sm-10">
                <label for="council_id">Fecha</label>
                <input type="date" class="form-control">
            </div>
         </div>
        
        <br>

        <div class="justify-content-center text-center">
            <button type="submit" class="btn btn-primary ">Guardar</button>
        </div>
    </form>
</div>

@endsection

