<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Council;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouncilsController extends Controller
{
    public function getIndex()
    {
        return view("admin.council.list");
    }

    public function getList()
    {
        $councils=Council::get();

        $councils_list=[];
        foreach($councils as $council)
        {
            $councils_list[]=[$council->name,\DateTime::createFromFormat("Y-m-d H:i:s",$council->created_at)->format("d-m-Y"),'<a href="'.route("admin_councils_edit",["council_id"=>$council->id]).'">Editar</a><a href="'.route("admin_councils_trash",["council_id"=>$council->id]).'">Borrar</a>'];
        }

        return response()->json(['data' => $councils_list]);
    }

    public function getCreate()
    {
        return view("admin.council.create");
    }

    public function create(Request $request)
    {
        $data=($request->only(["name"]));

        $checkCouncil=Council::where("name",$data["name"])->first();
        if($checkCouncil)
        {
            return redirect()->back()->withErrors(["El consejo que trata de crear ya existe"]);
        }

        $council=Council::create($data);

        return redirect()->route("admin_councils_edit",["council_id"=>$council->id])->with(["message_info"=>"Se ha creado el consejo"]);
    }

    public function getEdit($council_id)
    {
        $council=Council::where("id",$council_id)->first();
        return view("admin.council.edit",["council"=>$council]);
    }

    public function update(Request $request)
    {
        $data=($request->only(["name"]));
        $council_id=$request->get("council_id");

        $council=Council::where("id",$council_id)->first();

        $checkCouncil=Council::where("name",$data["name"])->first();
        if($checkCouncil && $checkCouncil->id!=$council->id)
        {
            return redirect()->back()->withErrors(["Ya existe un consejo con ese nombre asignado"]);
        }

        Council::where("id",$council_id)->update($data);

        return redirect()->route("admin_councils_edit",["council_id"=>$council_id])->with(["message_info"=>"Se ha actualizado el consejo"]);
    }

    public function getTrash($council_id)
    {
        $council=Council::where("id",$council_id)->first();

        return view("admin.council.trash",["council"=>$council]);
    }

    public function delete(Request $request)
    {
        $council_id=$request->get("council_id");

        Council::where("id",$council_id)->delete();

        return redirect()->route("admin_councils")->with(["message_info"=>"Se ha eliminado el consejo"]);
    }
}
