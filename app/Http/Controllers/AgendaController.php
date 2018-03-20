<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Agenda;
use App\Models\Point;
use Illuminate\Http\Request;
use App\Http\Requests\Agenda\CreateAgendaRequest;
use App\Http\Requests\Agenda\UpdateAgendaRequest;
use App\Http\Requests\Agenda\DeleteAgendaRequest;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    public function getIndex()
    {
        return view("agenda.list");
    }

    public function getList()
    {
        $agendas=Agenda::get();

        $agendas_list=[];
        foreach($agendas as $agenda)
        {
            $agendas_list[]=[$agenda->description,\DateTime::createFromFormat("Y-m-d",$agenda->event_date)->format("d/m/Y"),$agenda->status=="1"?"A tratar":"Tratada",'<a href="'.route("admin_agendas_edit",["agenda_id"=>$agenda->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Editar" class="fa fa-edit" aria-hidden="true"></i></a> <a href="'.route("admin_agendas_trash",["agenda_id"=>$agenda->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="fa fa-trash" aria-hidden="true"></i></a>'];
        }
        return response()->json(['data' => $agendas_list]);
    }

    public function getCreate()
    {
        return view("agenda.create");
    }

    public function create(CreateAgendaRequest $request)
    {
        $event_date=$request->event_date;
        $date=gmdate("Y-m-d");

        if($event_date<$date)
        {
            return redirect()->back()->withErrors(["No puede registrar una agenda en una fecha que ya pasó"]);
        }   

        $agenda=Agenda::create($request->all());

        $n=0;
        while(file_exists("docs/file_".$agenda->id."_".$date."_".$n.".pdf"))
        {
            $n++;
        }

        $request->attached_document->storeAs('docs/', 'file_'.$agenda->id.'_'.$date.'_'.$n.'.pdf', 'uploads');
        $attached_document="file_".$agenda->id."_".$date."_".$n.".pdf";

        Agenda::where("id",$agenda->id)->update(["attached_document"=>$attached_document]);

        /*$points = $request->points; // this is an array of points

        foreach($points as $key => $point)
        {
            $newPoint = new Point($point);

            $agenda->points()->save($point);
        }*/
        
        return redirect()->route("admin_agendas_edit",["agenda_id"=>$agenda->id])->with(["message_info"=>"Se ha registrado la agenda"]);
    }

    public function getEdit($agenda_id)
    {
        $agenda=Agenda::where("id",$agenda_id)->first();
        return view("agenda.edit",["agenda"=>$agenda]);
    }

    public function update(UpdateAgendaRequest $request)
    {
        $data=($request->only(["description","status","attached_document","event_date"]));
        $event_date=$data["event_date"];
        $date=gmdate("Y-m-d");

        if($event_date<$date)
        {
            return redirect()->back()->withErrors(["No puede registrar una agenda en una fecha que ya pasó"]);
        } 

        $agenda=Agenda::where('id','=',$request->agenda_id)->first();

        if($agenda==null)
        {
            return redirect()->back()->withErrors(["No existe la agenda a actualizar"]);
        }

        if(!empty($data["attached_document"]))
        {
            $n=0;
            while(file_exists("docs/file_".$agenda->id."_".$date."_".$n.".pdf"))
            {
                $n++;
            }

            $request->attached_document->storeAs('docs/', 'file_'.$agenda->id.'_'.$date.'_'.$n.'.pdf', 'uploads');
            $data["attached_document"]="file_".$agenda->id."_".$date."_".$n.".pdf";
        }
        else
        {
            $data["attached_document"]=$agenda->attached_document;
        }

        $agenda->update($data);

        return redirect()->route("admin_agendas_edit",["agenda_id"=>$request->agenda_id])->with(["message_info"=>"Se ha actualizado la agenda"]);
    }

    public function getTrash($agenda_id)
    {
        $agenda=Agenda::where("id",$agenda_id)->first();

        return view("agenda.trash",["agenda"=>$agenda]);
    }

    public function delete(DeleteAgendaRequest $request)
    {
        $agenda = Agenda::where('id','=',$request->agenda_id)->first();

        if(count($agenda->points)>0)
        {
            return redirect()->back()->withErrors(["No puede eliminar una agenda que tiene puntos asignados"]);
        }

        if($agenda->attached_document)
        {
            \Storage::disk("uploads")->delete("/docs/".$agenda->attached_document);
        }

        Agenda::where("id",$request->agenda_id)->delete();
        return redirect()->route("admin_agendas")->with(["message_info"=>"Se ha eliminado la agenda"]);
    }

}
