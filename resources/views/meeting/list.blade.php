@extends('layouts.home')

@section('title' , "Reuniones")

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')


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
 <h1 class="text-center mr1 font-weight-normal">Lista de Reuniones</h1>

<div class="form-group">
    <div class="  text-right pdr">
        <a class="btn  mr1 btn-outline-dark  "  href="" role="button">Registrar Reunión</a>
    </div>
</div>
<br>

<div class="table-responsive">
<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Presidente</th>
            <th>Fecha </th>
            <th><i></i></th>
        </tr>
    </thead>
</table>
</div>

@endsection

@section('script')
<script>
    
</script>
@endsection