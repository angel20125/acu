@extends('layouts.home')

@section('title' , "Finalizar Agenda")

@section('links')
    <link href="{{ asset('css/create_user.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row justify-content-center">
    <form class="form-signin col-lg-10 col-md-12 col-sm-12 " action="{{route("adjunto_diary_update")}}" method="post" enctype="multipart/form-data"">
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

        <input type="hidden" name="diary_id" value="{{$diary->id}}"/>
        <h1 class="text-center font-weight-normal">Finalizar Agenda</h1>
        <br><br>
        
        <div class="form-row">
            <div class="form-group col-md-3 col-sm-12">
                <label for="council_id">Consejo</label>
                <input name="council_id" type="text" class="form-control" value="{{$diary->council->name}}" disabled>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for="event_date">Fecha</label>
                <input name="event_date" type="date" class="form-control" id="event_date" value="{{$diary->event_date}}" disabled>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="place">Lugar</label>
                <input name="place" type="text" class="form-control" placeholder="Lugar donde se tratará la agenda" value="{{$diary->place}}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12 col-sm-12">
                <label for="description">Descripción de la agenda</label>
                <textarea name="description" class="form-control" id="description" rows="3" placeholder="Resúmen general de la temática a tratar en la agenda" required>{{$diary->description}}</textarea>
            </div>
        </div>

        <br>
        <h3 class="text-center font-weight-normal">Puntos Tratados</h3>
        <br>

        @foreach($diary->points->where("pre_status","incluido")->sortByDesc("created_at") as $point)
            <input type="hidden" name="point_id[]" value="{{$point->id}}"/>
            <div style="margin-bottom:50px; background:#f8f9fa; border-radius: 10px;">
                <div class="container-fluid">
                    <div class="row justify-content-between" style="padding-left: 12px; padding-right: 2px">
                        <h3 class="text-center font-weight-normal">Punto</h3>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-9">
                            <label>Descripción del Punto</label>
                            <textarea name="description_point[]" class="form-control" id="description" rows="3" required>{{$point->description}}</textarea>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            <label>Tipo</label>
                            <select name="type[]" class="form-control" required>
                                <option value="{{$point->type}}">{{$point->type=="info"?"Información":"Decisión"}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                @if($point->type=="decision")
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-9">
                                <label>Acuerdo</label>
                                <textarea name="agreement[]" class="form-control" id="agreement" rows="3" required></textarea>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <label>Estatus</label>
                                <select name="post_status[]" class="form-control" required>
                                    <option value="aprobado">Aprobado</option>
                                    <option value="rechazado">Rechazado</option>
                                    <option value="diferido">Diferido</option>
                                    <option value="diferido_virtual">Diferido Virtual</option>
                                    <option value="retirado">Retirado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-9">
                                <label>Acuerdo</label>
                                <textarea name="agreement[]" class="form-control" id="agreement" rows="3"></textarea>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <label>Estatus</label>
                                <select name="post_status[]" class="form-control" required>
                                    <option value="presentado">Presentado</option>
                                    <option value="no_presentado">No Presentado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                @if(count($point->documents)>0)
                    <br>
                    <div class="justify-content-center text-center">
                        @foreach($point->documents as $k => $document)
                            @if(file_exists("docs/".$document->direction))
                                <a href="{{asset("docs/".$document->direction)}}" class="btn btn-success">Documento {{$k+1}}</a>
                            @endif
                        @endforeach
                    </div>
                @endif
                <br>
            </div>
        @endforeach
            
        <div id="inputPoints"></div>

        <!-- Aqui el codigo de los puntos-->
        <div class="justify-content-end text-right">
            <button id="btn-add" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Punto</button>
        </div>

        <br>
       
        <div class="justify-content-center text-center">
            <button type="submit" class="btn btn-primary ">Actualizar</button>
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
                inputPoints.append('<div style="margin-bottom:50px; background:#f8f9fa; border-radius: 10px;" class="point-'+i+'"><div class="container-fluid"><div class="row justify-content-between" style="padding-left: 12px; padding-right: 2px"><h3 class="text-center font-weight-normal" >Punto</h3><button value="'+i+'" type="button" id="remove-point-'+i+'" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Eliminar Punto"><i class="fa fa-trash text-right" aria-hidden="true" ></i></div><div class="row"><div class="col-xs-12 col-sm-6"><label>Descripción del Punto</label><textarea name="description_point[]" class="form-control" id="description" rows="3" required></textarea></div>          <div class="col-xs-12 col-sm-3"><label>Presentador</label><select name="user_id[]" class="form-control" required>        @foreach($diary->council->users as $user)<option value="{{$user->id}}">{{$user->last_name}} {{$user->first_name}}</option>@endforeach</select></div>          <div class="col-xs-12 col-sm-3"><label>Tipo</label><select name="type[]" class="form-control" required><option value="info">Información</option><option value="decision">Decisión</option></select></div></div></div><br><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-9"><label>Acuerdo</label><textarea name="agreement[]" class="form-control" id="agreement" rows="3" required></textarea></div><div class="col-xs-12 col-sm-3"><label>Estatus</label><select name="post_status[]" class="form-control" required><option value="presentado">Presentado</option><option value="no_presentado">No Presentado</option><option value="aprobado">Aprobado</option><option value="rechazado">Rechazado</option><option value="diferido">Diferido</option><option value="diferido_virtual">Diferido Virtual</option><option value="retirado">Retirado</option></select></div></div></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_one[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file" >Documento de soporte 1 .pdf</label></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_two[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 2 .pdf</label></div></div></div></div><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6"><br><div class="custom-file"><input name="attached_document_three[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 3 .pdf</label></div></div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" style="margin-bottom:25px;"><br><div class="custom-file"><input name="attached_document_four[]" type="file" class="custom-file-input" id="load_file" lang="es"><label class="custom-file-label" for="load_file">Documento de soporte 4 .pdf</label></div></div></div></div></div>');

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
