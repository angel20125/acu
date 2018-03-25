<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Council;
use App\Models\Role;
use App\Models\Transaction;
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
            $councils_list[]=[$council->name,$council->president==null?"NA":$council->president->last_name." ".$council->president->first_name,$council->adjunto==null?"NA":$council->adjunto->last_name." ".$council->adjunto->first_name,\DateTime::createFromFormat("Y-m-d H:i:s",$council->created_at)->format("d-m-Y"),'<a href="'.route("admin_councils_edit",["council_id"=>$council->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Editar" class="fa fa-edit" aria-hidden="true"></i></a> <a href="'.route("admin_councils_trash",["council_id"=>$council->id]).'"><i data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="fa fa-trash" aria-hidden="true"></i></a>'];
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
            return redirect()->back()->withErrors(["El consejo que trata de registar ya existe"]);
        }

        $council=Council::create($data);

        return redirect()->route("admin_councils_edit",["council_id"=>$council->id])->with(["message_info"=>"Se ha registrado el consejo"]);
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

        $president_id=$request->get("president_id");
        $adjunto_id=$request->get("adjunto_id");

        $council=Council::where("id",$council_id)->first();

        if($president_id==$adjunto_id) 
        {
            return redirect()->back()->withErrors(["Un usuario no puede puede tener dos cargos dentro de un mismo consejo"]);
        }

        if($president_id!=$council->president->id)
        {
            $last_president=$council->president;

            //Agregar fecha final del período del presidente actual
            Transaction::where("type","create_user_presidente")->where("user_id",$last_president->id)->where("affected_id",$council_id)->where("end_date",null)->update(["end_date"=>gmdate("d/m/Y")]);

            //Eliminar el presidente actual del consejo
            Council::where("id",$council_id)->update(["president_id"=>null]);

            //Desvincular el presidente actual del consejo
            $last_president->councils()->detach($council_id);

            //El presidente actual ahora pasa a ser un consejero
            Transaction::create(["type"=>"create_user_consejero","user_id"=>$last_president->id,"affected_id"=>$council_id,"start_date"=>gmdate("d/m/Y")]);

            //El presidente actual ahora es degredado a consejero
            $rol=Role::where("name","consejero")->first();
            $last_president->councils()->attach($council_id,["role_id"=>$rol->id]);

            //Nuevo presidente
            $new_president=User::where("id",$president_id)->first();

            //Agregar fecha final del período del consejero que ahora será presidente
            Transaction::where("type","create_user_consejero")->where("user_id",$president_id)->where("affected_id",$council_id)->where("end_date",null)->update(["end_date"=>gmdate("d/m/Y")]);

            //Desvincular el presidente actual del consejo
            $new_president->councils()->detach($council_id);

            //Agregar fecha inicial del período del presidente nuevo
            Transaction::create(["type"=>"create_user_presidente","user_id"=>$president_id,"affected_id"=>$council_id,"start_date"=>gmdate("d/m/Y")]);

            //Agregar el presidente nuevo al consejo
            Council::where("id",$council_id)->update(["president_id"=>$president_id]);

            //El consejero actual ahora será presidente
            $rol=Role::where("name","presidente")->first();
            $new_president->councils()->attach($council_id,["role_id"=>$rol->id]);
        }

        if($adjunto_id!=$council->adjunto->id)
        {
            $last_adjunto=$council->adjunto;

            //Agregar fecha final del período del adjunto actual
            Transaction::where("type","create_user_adjunto")->where("user_id",$last_adjunto->id)->where("affected_id",$council_id)->where("end_date",null)->update(["end_date"=>gmdate("d/m/Y")]);

            //Eliminar el adjunto actual del consejo
            Council::where("id",$council_id)->update(["adjunto_id"=>null]);

            //Desvincular el adjunto actual del consejo
            $last_adjunto->councils()->detach($council_id);

            //El adjunto actual ahora pasa a ser un consejero
            Transaction::create(["type"=>"create_user_consejero","user_id"=>$last_adjunto->id,"affected_id"=>$council_id,"start_date"=>gmdate("d/m/Y")]);

            //El adjunto actual ahora es degredado a consejero
            $rol=Role::where("name","consejero")->first();
            $last_adjunto->councils()->attach($council_id,["role_id"=>$rol->id]);

            //Nuevo adjunto
            $new_adjunto=User::where("id",$adjunto_id)->first();

            //Agregar fecha final del período del consejero que ahora será adjunto
            Transaction::where("type","create_user_consejero")->where("user_id",$adjunto_id)->where("affected_id",$council_id)->where("end_date",null)->update(["end_date"=>gmdate("d/m/Y")]);

            //Desvincular el adjunto actual del consejo
            $new_adjunto->councils()->detach($council_id);

            //Agregar fecha inicial del período del adjunto nuevo
            Transaction::create(["type"=>"create_user_adjunto","user_id"=>$adjunto_id,"affected_id"=>$council_id,"start_date"=>gmdate("d/m/Y")]);

            //Agregar el adjunto nuevo al consejo
            Council::where("id",$council_id)->update(["adjunto_id"=>$adjunto_id]);

            //El consejero actual ahora será adjunto
            $rol=Role::where("name","adjunto")->first();
            $new_adjunto->councils()->attach($council_id,["role_id"=>$rol->id]);
        }

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

        $council=Council::where("id",$council_id)->first();

        if(count($council->users)>0) 
        {
            return redirect()->back()->withErrors(["No puede eliminar un consejo que tiene usuarios asignados"]);
        }

        Council::where("id",$council_id)->delete();
        return redirect()->route("admin_councils")->with(["message_info"=>"Se ha eliminado el consejo"]);
    }
}
