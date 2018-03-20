@extends('layouts.home')

@section('title' , "Reuniones")

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')

<br>
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

<div class="row justify-content-end">
    <div class=" col-xl-2 col-lg-3 col-md-4 col-sm-4 ">
        <a class="btn  mr1 btn-outline-dark"  href="#" role="button">Registrar Reunión</a>
    </div>
</div>
<br>

<div class="table-responsive">
<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Presidente</th>
            <th>Fecha </th>
            <th><i class="fa fa-sync"></i></th>
        </tr>
    </thead>
</table>
</div>

@endsection

@section('script')
<script>
    
</script>
@endsection