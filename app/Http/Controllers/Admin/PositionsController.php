<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionsController extends Controller
{
    public function getIndex()
    {
        return view("admin.position.list");
    }

    public function getList()
    {
        $positions=Position::where("name","<>","Administrador")->where("name","<>","Secretary")->get();

        $positions_list=[];
        foreach($positions as $position)
        {
            $positions_list[]=[$position->name,\DateTime::createFromFormat("Y-m-d H:i:s",$position->created_at)->format("d-m-Y"),'<a href="'.route("admin_positions_edit",["position_id"=>$position->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Editar" class="fa fa-edit" aria-hidden="true"></i></a> <a href="'.route("admin_positions_trash",["position_id"=>$position->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="fa fa-trash" aria-hidden="true"></i></a>'];
        }

        return response()->json(['data' => $positions_list]);
    }

    public function getCreate()
    {
        return view("admin.position.create");
    }

    public function create(Request $request)
    {
        $data=($request->only(["name"]));

        $checkPosition=Position::where("name",$data["name"])->first();
        if($checkPosition)
        {
            return redirect()->back()->withErrors(["El cargo que trata de registar ya existe"]);
        }

        $position=Position::create($data);

        return redirect()->route("admin_positions_edit",["position_id"=>$position->id])->with(["message_info"=>"Se ha registrado el cargo"]);
    }

    public function getEdit($position_id)
    {
        $position=Position::where("id",$position_id)->first();
        return view("admin.position.edit",["position"=>$position]);
    }

    public function update(Request $request)
    {
        $data=($request->only(["name"]));
        $position_id=$request->get("position_id");

        $position=Position::where("id",$position_id)->first();

        $checkPosition=Position::where("name",$data["name"])->first();
        if($checkPosition && $checkPosition->id!=$position->id)
        {
            return redirect()->back()->withErrors(["Ya existe un cargo con ese nombre asignado"]);
        }

        Position::where("id",$position_id)->update($data);

        return redirect()->route("admin_positions_edit",["position_id"=>$position_id])->with(["message_info"=>"Se ha actualizado el cargo"]);
    }

    public function getTrash($position_id)
    {
        $position=Position::where("id",$position_id)->first();

        return view("admin.position.trash",["position"=>$position]);
    }

    public function delete(Request $request)
    {
        $position_id=$request->get("position_id");

        $position=Position::where("id",$position_id)->first();

        if(count($position->users)>0)
        {
            return redirect()->back()->withErrors(["No puede eliminar un cargo que tiene usuarios asignados"]);
        }

        Position::where("id",$position_id)->delete();
        return redirect()->route("admin_positions")->with(["message_info"=>"Se ha eliminado el cargo"]);
    }
}
