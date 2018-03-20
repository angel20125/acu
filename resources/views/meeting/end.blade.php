@extends('layouts.home')

@section('title' , "Finalizar reunión")

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
        <h1 class="text-center font-weight-normal">Finalizar reunión</h1>
        <br><br>
        
        
            <div class="form-row">
            <div class="form-group col-lg-3 col-md-5 col-sm-6">
                <label for="assistance_input">Asistencia</label>
                <div class="input-group mb-3">
                    <input name="assistance" type="text" id="assistance" class="form-control" placeholder="Numero de personas"   required autofocus onkeypress="return numeros(event) ">
                </div>
            </div>
            <div class="form-group col-lg-9 col-md-7 col-sm-6">
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
@section('script')
    <script type="text/javascript" src="{{ asset('js/create_user.js') }}"></script>
@endsection
