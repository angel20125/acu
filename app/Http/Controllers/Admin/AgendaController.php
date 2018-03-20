<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Agenda;
use App\Models\Point;
use Illuminate\Http\Request;
use App\Http\Requests\Agenda\CreateAgendaRequest;
use App\Http\Requests\Agenda\DeleteAgendaRequest;
use App\Http\Requests\Agenda\UpdateAgendaRequest;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    public function getIndex()
    {
        return view("admin.agenda.list");
    }

    public function getList()
    {
        $agendas=Agenda::get();

        $agendas_list=[];
        foreach($agendas as $agenda)
        {
            $agendas_list[]=[$agenda->name,\DateTime::createFromFormat("Y-m-d H:i:s",$agenda->created_at)->format("d-m-Y"),'<a href="'.route("admin_agendas_edit",["agenda_id"=>$agenda->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Editar" class="fa fa-edit" aria-hidden="true"></i></a> <a href="'.route("admin_agendas_trash",["agenda_id"=>$agenda->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="fa fa-trash" aria-hidden="true"></i></a>'];
        }
        return response()->json(['data' => $agendas_list]);
    }

    public function getCreate()
    {
        return view("admin.agenda.create");
    }

    public function create(CreateAgendaRequest $request)
    {
        $newAgenda = Agenda::create($request->all());

        /*$points = $request->points; // this is an array of points

        foreach($points as $key => $point)
        {
            $newPoint = new Point($point);

            $newAgenda->points()->save($point);
        }*/
        
        return redirect()->route("admin_agendas_edit",["agenda_id"=>$agenda->id])->with(["message_info"=>"Se ha registrado la agenda"]);
    }

    public function getEdit($agenda_id)
    {
        $agenda=Agenda::where("id",$agenda_id)->first();
        return view("admin.agenda.edit",["agenda"=>$agenda]);
    }

    public function update(UpdateAgendaRequest $request)
    {
        $agenda = Agenda::where('id','=',$request->agenda_id)->first();

        if ($agenda == null) {
            return response()->json(['error' => 'La agenda no se encontró'], 404);
        }

        $agenda->update($request->all());

        return redirect()->route("admin_agendas_edit",["agenda_id"=>$agenda_id])->with(["message_info"=>"Se ha actualizado la agenda"]);
    }

    public function getTrash($agenda_id)
    {
        $agenda=Agenda::where("id",$agenda_id)->first();

        return view("admin.agenda.trash",["agenda"=>$agenda]);
    }

    public function delete(DeleteAgendaRequest $request)
    {
        $agenda = Agenda::where('id','=',$request->agenda_id)->first();

        if(count($agenda->points)>0)
        {
            return redirect()->back()->withErrors(["No puede eliminar una agenda que tiene puntos asignados"]);
        }

        Agenda::where("id",$agenda_id)->delete();
        return redirect()->route("admin_agendas")->with(["message_info"=>"Se ha eliminado la agenda"]);
    }

}
