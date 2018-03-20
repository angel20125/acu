@extends('layouts.home')

@section('title' , "Editar reunión")

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
        <h1 class="text-center font-weight-normal">Editar reunión</h1>
        <br><br>
    
        <div class="form-row justify-content-center">
            <div class="form-group col-md-7 col-sm-10">
                <label for="date">Fecha</label>
                <input name="date" type="date" class="form-control" value="12/04/2018" id="date"> 
            </div>
            <div class="form-group col-md-5 col-sm-10">
                
                <label for="president_input">Presidente</label>
                <select name="president" class="form-control" id="president" required>
                    <option> Victor Leon</option>
                    
                </select>

            </div>
        </div>
        
        <br>

        <div class="justify-content-center text-center">
            <button type="submit" class="btn btn-primary ">Registrar</button>
        </div>
    </form>
</div>

@endsection