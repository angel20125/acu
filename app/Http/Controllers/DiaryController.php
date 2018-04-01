<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Council;
use App\Models\Diary;
use App\Models\Document;
use App\Models\Role;
use App\Models\Point;
use Illuminate\Http\Request;
use App\Http\Requests\Diary\CreateDiaryRequest;
use App\Http\Requests\Diary\UpdateDiaryRequest;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;

class DiaryController extends Controller
{
    public function getLimitedIndex()
    {
        return view("diary.list_limited");
    }

    public function getListLimited()
    {
        $diaries=Diary::get();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diaries_list=[];
        foreach($diaries as $diary)
        {
            if($current_date <= $diary->event_date)
            {
                $status="Pre-Agenda"; 
            }
            elseif($current_date > $diary->event_date && $diary->status==0)
            {
                $status="Pre-Agenda (Por finalizar)";
            }  
            else
            {
                $status="Post-Agenda";
            }
            $diaries_list[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d-m-Y"),substr($diary->description, 0, 20)."...",$status,$diary->council->name,$diary->council->president==null?"No asignado":$diary->council->president->last_name." ".$diary->council->president->first_name,'<a href="'.route("diary_pdf",["diary_id"=>$diary->id]).'"><i class="fa fa-print" aria-hidden="true"></i></a> <a href="'.route("get_diary",["diary_id"=>$diary->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a>'];
        }
        return response()->json(['data' => $diaries_list]);
    }

    public function getAdjuntoIndex()
    {
        return view("diary.list_adjunto");
    }

    public function getListAdjunto()
    {
        $user=User::getCurrent();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diaries_list=[];
        foreach($user->councils as $council) 
        {
            foreach($council->diaries->where("event_date","<=",$current_date)->where("status",0) as $diary) 
            {
                if($user->getCurrentRol()->id==$council->pivot->role_id)
                {
                    if($current_date <= $diary->event_date)
                    {
                        $status="Pre-Agenda"; 
                    }
                    elseif($current_date > $diary->event_date && $diary->status==0)
                    {
                        $status="Pre-Agenda (Por finalizar)";
                    }  
                    else
                    {
                        $status="Post-Agenda";
                    }

                    $diaries_list[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d-m-Y"),substr($diary->description, 0, 20)."...",$status,$diary->council->name,$diary->council->president==null?"No asignado":$diary->council->president->last_name." ".$diary->council->president->first_name,'<a href="'.route("diary_pdf",["diary_id"=>$diary->id]).'"><i class="fa fa-print" aria-hidden="true"></i></a> <a href="'.route("get_diary",["diary_id"=>$diary->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a> <a href="'.route("adjunto_diaries_edit",["diary_id"=>$diary->id]).'"><i class="fa fa-edit" aria-hidden="true"></i></a>'];
                }
            }
        }

        return response()->json(['data' => $diaries_list]);
    }

    public function getDiaryAdjunto($diary_id)
    {
        $user=User::getCurrent();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diary=Diary::where("id",$diary_id)->first();

        if(!$diary) 
        {
            return redirect()->route("adjunto_dashboard")->withErrors(["La pre-agenda que trata de finalizar no existe"]);
        }

        $user_council=$user->councils()->wherePivot("council_id",$diary->council->id)->first();

        if(($diary && $user_council && $diary->council->id!=$user_council->id) || !$user_council) 
        {
            return redirect()->route("adjunto_dashboard")->withErrors(["No tiene permisos de finalizar esa determinada pre-agenda"]);
        }
        
        if($diary->event_date > $current_date) 
        {
            return redirect()->route("adjunto_dashboard")->withErrors(["La pre-agenda que trata de finalizar aún no se ha llevado a cabo"]);
        }

        return view("diary.end",["diary"=>$diary]);
    }

    public function getIndex()
    {
        return view("diary.list");
    }

    public function getList()
    {
        $diaries=Diary::get();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diaries_list=[];
        foreach($diaries as $diary)
        {
            if($current_date <= $diary->event_date)
            {
                $status="Pre-Agenda"; 
            }
            elseif($current_date > $diary->event_date && $diary->status==0)
            {
                $status="Pre-Agenda (Por finalizar)";
            }  
            else
            {
                $status="Post-Agenda";
            }

            $diaries_list[]=[\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d-m-Y"),substr($diary->description, 0, 20)."...",$status,$diary->council->name,$diary->council->president==null?"No asignado":$diary->council->president->last_name." ".$diary->council->president->first_name,'<a href="'.route("diary_pdf",["diary_id"=>$diary->id]).'"><i class="fa fa-print" aria-hidden="true"></i></a> <a href="'.route("get_diary",["diary_id"=>$diary->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a> <a href="'.route("admin_diaries_trash",["diary_id"=>$diary->id]).'"><i class="fa fa-trash" aria-hidden="true"></i></a>'];
        }
        return response()->json(['data' => $diaries_list]);
    }

    public function getDiary($diary_id)
    {
        $diary=Diary::where("id",$diary_id)->first();

        return view("diary.show",["diary"=>$diary]);
    }

    public function getCreate()
    {
        $user=User::getCurrent();
        $councils=null;

        if($user->getCurrentRol()->name=="admin")
        {
            $councils=Council::orderBy("name","asc")->get();
        }
        elseif($user->getCurrentRol()->name=="presidente")
        {
            $new_councils=[];
            $councils=$user->councils;
            foreach($councils as $key => $council) 
            {
                if($council->president && $council->president->id==$user->id) 
                {
                    $new_councils[]=$council;
                }
            }
        }
        elseif($user->getCurrentRol()->name=="adjunto")
        {
            $new_councils=[];
            $councils=$user->councils;
            foreach($councils as $key => $council) 
            {
                if($council->adjunto && $council->adjunto->id==$user->id) 
                {
                    $new_councils[]=$council;
                }
            }
        }

        if(count($councils)==0 && $user->hasRole("admin"))
        {
            return redirect()->route("admin_councils_create")->withErrors(["Primero debes registrar un consejo como mínimo, para poder registrar o convocar una nueva pre-agenda"]);
        }

        if($user->hasRole("admin")) 
        {
            return view("diary.create",["councils"=>$councils]);
        }
        else
        {
            return view("diary.create",["councils"=>$new_councils]);
        }
    }

    public function create(CreateDiaryRequest $request)
    {
        $user=User::getCurrent();

        $event_date=$request->event_date;

        $date = new \DateTime("now");
        $date = $date->format("Y-m-d");

        if($event_date<$date)
        {
            return redirect()->back()->withErrors(["No puede registrar o convocar una nueva pre-agenda en una fecha que ya pasó"]);
        }

        $dataPoints=($request->only(["description_point","type","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));

        $data=($request->only(["council_id","description","place","event_date"]));
        
        if($event_date==$date)
        {
            $data["limit_date"]=$event_date;
        }
        else
        {
            $data["limit_date"]=\DateTime::createFromFormat("Y-m-d",$event_date)->sub(new \DateInterval("P1D"))->format("Y-m-d");
        }

        $council=Council::where("id",$data["council_id"])->first();

        $current_agenda=Diary::where("council_id",$data["council_id"])->where("event_date",$event_date)->first();

        if($current_agenda) 
        {
            return redirect()->back()->withErrors(["El presidente o adjunto del ".$council->name." ya registró una nueva pre-agenda para el día ".\DateTime::createFromFormat("Y-m-d",$event_date)->format("d/m/Y")]);
        }   

        if(!isset($dataPoints["description_point"]))
        {
            $diary=Diary::create($data);
        }
        else
        {
            $diary=Diary::create($data);

            foreach($dataPoints["description_point"] as $key => $description)
            {
                $point=Point::create(
                [
                  'user_id' => $user->id,
                  'diary_id' => $diary->id,
                  'title' => "punto_".$key,
                  'description' => $description,
                  'type' => $dataPoints["type"][$key],
                  'pre_status' => "incluido"
                ]);

                $new_date = new \DateTime("now");
                $new_date = $new_date->format("d_m_Y");

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_one"][$key]))
                {
                    $request->attached_document_one[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_two"][$key]))
                {
                    $request->attached_document_two[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_three"][$key]))
                {
                    $request->attached_document_three[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_four"][$key]))
                {
                    $request->attached_document_four[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }
            }
        }

        foreach($council->users as $user) 
        {
            $council_user=$user->councils()->where("id",$diary->council->id)->first();

            $rol=Role::where("id",$council_user->pivot->role_id)->first();

            if($rol->name=="consejero" && $user->status && $user->validate) 
            {
                \Mail::send('emails.user_invitation', ["user"=>$user,"council"=>$council,"diary"=>$diary], function($message) use($user,$council)
                {
                    $message->subject("Invitación del ".$council->name);
                    $message->to($user->email,$user->first_name);
                });
            }
        }

        if($user->getCurrentRol()->name=="admin")
        {
            return redirect()->route("admin_diaries")->with(["message_info"=>"Se ha registrado la pre-agenda exitosamente"]);
        }
        else
        {
            return redirect()->route("diaries")->with(["message_info"=>"Se ha registrado la pre-agenda exitosamente"]);
        }
    }

    public function getSecretaryProposePoints()
    {
        $user=User::getCurrent();

        $users=$user->positionBoss->users;

        if(count($users)==0)
        {
            return redirect()->route("secretaria_dashboard")->withErrors(["No se han registrado usuarios superiores a tu cargo, que te autoricen para proponer puntos"]);
        }

        return view("point.propose_points",["members"=>$users]);
    }

    public function getListSelectSecretary($user_id)
    {
        $user=User::where("id",$user_id)->first();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diaries_list=[];
        foreach($user->councils as $council) 
        {
            foreach($council->diaries->where("limit_date",">=",$current_date) as $diary)
            {
                $diaries_list[]=[$diary->id, $council->name." - ".\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")];
            }
        }

        return response()->json(['data' => $diaries_list]);
    }

    public function SecretaryProposePoints(Request $request)
    {
        $dataPoints=($request->only(["user_id","diary_id","description_point","type","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));

        $user=User::where("id",$dataPoints["user_id"])->first();
        $diary=Diary::where("id",$dataPoints["diary_id"])->first();
        
        $council=$user->councils()->where("id",$diary->council->id)->first();

        $rol=Role::where("id",$council->pivot->role_id)->first();

        if($rol->name=="presidente" || $rol->name=="adjunto") 
        {
            $pre_status="incluido";
        }
        else
        {
            $pre_status="propuesto";
        }  

        if(!isset($dataPoints["description_point"]))
        {
            return redirect()->back()->withErrors(["Debe presentar un punto como mínimo"]);
        }
        else
        {
            foreach($dataPoints["description_point"] as $key => $description)
            {
                $point=Point::create(
                [
                  'user_id' => $dataPoints["user_id"],
                  'diary_id' => $diary->id,
                  'title' => "punto_".$key,
                  'description' => $description,
                  'type' => $dataPoints["type"][$key],
                  'pre_status' => $pre_status
                ]);

                $new_date = new \DateTime("now");
                $new_date = $new_date->format("d_m_Y");

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_one"][$key]))
                {
                    $request->attached_document_one[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_two"][$key]))
                {
                    $request->attached_document_two[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_three"][$key]))
                {
                    $request->attached_document_three[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_four"][$key]))
                {
                    $request->attached_document_four[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }
            }
            
            return redirect()->route("diaries")->with(["message_info"=>"Se han agregado/presentado exitosamente los puntos"]);
        }
    }

    public function getPoints()
    {
        return view("point.president_points");
    }

    public function getPointsDes()
    {
        return view("point.president_points_des");
    }

    public function evaluatePoint($point_id,$evaluation)
    {
        $point=Point::where("id",$point_id)->update(["pre_status"=>$evaluation]);

        if($evaluation=="incluido") 
        {
            return redirect()->route("get_presidente_points")->with(["message_info"=>"Punto incluido exitosamente en la pre-agenda"]);
        }
        else
        {
            return redirect()->route("get_presidente_points")->withErrors(["Punto desglosado exitosamente de la pre-agenda"]);
        }

    }

    public function evaluatePointDes($point_id,$evaluation)
    {
        $point=Point::where("id",$point_id)->update(["pre_status"=>$evaluation]);

        return redirect()->route("get_presidente_points_des")->with(["message_info"=>"Punto incluido exitosamente en la pre-agenda"]);
    }

    public function getPresidenteProposePoints()
    {
        $user=User::getCurrent();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diaries_list=[];
        foreach($user->councils as $council) 
        {
            if($user->getCurrentRol()->id===$council->pivot->role_id)
            {
                foreach($council->diaries->where("limit_date",">=",$current_date) as $diary)
                {
                    $diaries_list[]=[$diary->id, $council->name." - ".\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")];
                }
            }
        }

        if(count($diaries_list)==0)
        {
            return redirect()->route("presidente_dashboard")->withErrors(["No existen pre-agendas registradas para los próximos días donde actúas como presidente o el límite de la fecha para 'Agregar Puntos' ya se agotó, te invitamos a que registres una nueva en 'Registrar Agenda', para que posteriormente puedas 'Agregar Puntos'"]);
        }

        return view("point.president_points_propose");
    }

    public function PresidenteProposePoints(Request $request)
    {
        $user=User::getCurrent();

        $dataPoints=($request->only(["diary_id","description_point","type","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));   

        if(!isset($dataPoints["description_point"]))
        {
            return redirect()->back()->withErrors(["Debe agregar un punto como mínimo"]);
        }
        else
        {
            $diary=Diary::where("id",$dataPoints["diary_id"])->first();

            foreach($dataPoints["description_point"] as $key => $description)
            {
                $point=Point::create(
                [
                  'user_id' => $user->id,
                  'diary_id' => $diary->id,
                  'title' => "punto_".$key,
                  'description' => $description,
                  'type' => $dataPoints["type"][$key],
                  'pre_status' => 'incluido'
                ]);

                $new_date = new \DateTime("now");
                $new_date = $new_date->format("d_m_Y");

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_one"][$key]))
                {
                    $request->attached_document_one[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_two"][$key]))
                {
                    $request->attached_document_two[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_three"][$key]))
                {
                    $request->attached_document_three[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_four"][$key]))
                {
                    $request->attached_document_four[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }
            }
            
            return redirect()->route("president_history_points")->with(["message_info"=>"Se han agregado exitosamente los puntos"]);
        }
    }

    public function getAdjuntoProposePoints()
    {
        $user=User::getCurrent();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diaries_list=[];
        foreach($user->councils as $council) 
        {
            if($user->getCurrentRol()->id===$council->pivot->role_id)
            {
                foreach($council->diaries->where("limit_date",">=",$current_date) as $diary)
                {
                    $diaries_list[]=[$diary->id, $council->name." - ".\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")];
                }
            }
        }

        if(count($diaries_list)==0)
        {
            return redirect()->route("adjunto_dashboard")->withErrors(["No existen pre-agendas registradas para los próximos días donde actúas como adjunto o el límite de la fecha para 'Agregar Puntos' ya se agotó, te invitamos a que registres una nueva en 'Registrar Agenda', para que posteriormente puedas 'Agregar Puntos'"]);
        }

        return view("point.adjunto_points");
    }

    public function AdjuntoProposePoints(Request $request)
    {
        $user=User::getCurrent();

        $dataPoints=($request->only(["diary_id","description_point","type","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));   

        if(!isset($dataPoints["description_point"]))
        {
            return redirect()->back()->withErrors(["Debe agregar un punto como mínimo"]);
        }
        else
        {
            $diary=Diary::where("id",$dataPoints["diary_id"])->first();

            foreach($dataPoints["description_point"] as $key => $description)
            {
                $point=Point::create(
                [
                  'user_id' => $user->id,
                  'diary_id' => $diary->id,
                  'title' => "punto_".$key,
                  'description' => $description,
                  'type' => $dataPoints["type"][$key],
                  'pre_status' => 'incluido'
                ]);

                $new_date = new \DateTime("now");
                $new_date = $new_date->format("d_m_Y");

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_one"][$key]))
                {
                    $request->attached_document_one[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_two"][$key]))
                {
                    $request->attached_document_two[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_three"][$key]))
                {
                    $request->attached_document_three[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_four"][$key]))
                {
                    $request->attached_document_four[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }
            }
            
            return redirect()->route("adjunto_history_points")->with(["message_info"=>"Se han agregado exitosamente los puntos"]);
        }
    }

    public function getConsejeroProposePoints()
    {
        $user=User::getCurrent();

        $current_date = new \DateTime("now");
        $current_date = $current_date->format("Y-m-d");

        $diaries_list=[];
        foreach($user->councils as $council) 
        {
            if($user->getCurrentRol()->id===$council->pivot->role_id)
            {
                foreach($council->diaries->where("limit_date",">=",$current_date) as $diary)
                {
                    $diaries_list[]=[$diary->id, $council->name." - ".\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")];
                }
            }
        }

        if(count($diaries_list)==0)
        {
            return redirect()->route("consejero_dashboard")->withErrors(["No existen pre-agendas registradas para los próximos días donde actúas como consejero o el límite de la fecha para 'Presentar Puntos' ya se agotó, te invitamos a esperar a que el presidente o adjunto del consejo donde participas, registre una nueva pre-agenda para que puedas 'Presentar Puntos'"]);
        }

        return view("point.consejero_points");
    }

    public function ConsejeroProposePoints(Request $request)
    {
        $user=User::getCurrent();

        $dataPoints=($request->only(["diary_id","description_point","type","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));   

        if(!isset($dataPoints["description_point"]))
        {
            return redirect()->back()->withErrors(["Debe presentar un punto como mínimo"]);
        }
        else
        {
            $diary=Diary::where("id",$dataPoints["diary_id"])->first();

            foreach($dataPoints["description_point"] as $key => $description)
            {
                $point=Point::create(
                [
                  'user_id' => $user->id,
                  'diary_id' => $diary->id,
                  'title' => "punto_".$key,
                  'description' => $description,
                  'type' => $dataPoints["type"][$key],
                  'pre_status' => 'propuesto'
                ]);

                $new_date = new \DateTime("now");
                $new_date = $new_date->format("d_m_Y");

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_one"][$key]))
                {
                    $request->attached_document_one[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_two"][$key]))
                {
                    $request->attached_document_two[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_three"][$key]))
                {
                    $request->attached_document_three[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_four"][$key]))
                {
                    $request->attached_document_four[$key]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }
            }
            
            return redirect()->route("consejero_history_points")->with(["message_info"=>"Se han propuesto exitosamente los puntos"]);
        }
    }

    public function getHistoryPoints()
    {
        return view("point.consejero_propose_points");
    }

    public function getPresidentHistoryPoints()
    {
        return view("point.president_added_points");
    }

    public function diaryUpdate(Request $request)
    {
        $dataPoints=($request->only(["place","description","user_id","diary_id","point_id","description_point","type","agreement","post_status","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));

        $diary_id=$dataPoints["diary_id"];

        $diary=Diary::where("id",$diary_id)->update(["status"=>1,"place"=>$dataPoints["place"],"description"=>$dataPoints["description"]]);

        foreach($dataPoints["description_point"] as $key => $description)
        {
            if(isset($dataPoints["point_id"][$key]))
            {
                $point=Point::where("id",$dataPoints["point_id"][$key])->first();
            }
            else
            {
                $point=null;
            }

            if(!$point)
            {
                $count=0;
                $point=Point::create(
                [
                    'user_id' => $dataPoints["user_id"][$count],
                    'diary_id' => $diary_id,
                    'title' => "punto_".$key,
                    'description' => $description,
                    'type' => $dataPoints["type"][$key],
                    'pre_status' => "incluido",
                    'agreement' => $dataPoints["agreement"][$key],
                    'post_status' => $dataPoints["post_status"][$key]
                ]);

                $new_date = new \DateTime("now");
                $new_date = $new_date->format("d_m_Y");

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_one"][$count]))
                {
                    $request->attached_document_one[$count]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_two"][$count]))
                {
                    $request->attached_document_two[$count]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_three"][$count]))
                {
                    $request->attached_document_three[$count]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }

                $n=0;
                while(file_exists("docs/file_".$point->id."_".$new_date."_".$n.".pdf"))
                {
                    $n++;
                }

                if(!empty($dataPoints["attached_document_four"][$count]))
                {
                    $request->attached_document_four[$count]->storeAs('docs/', 'file_'.$point->id.'_'.$new_date.'_'.$n.'.pdf', 'uploads');
                    $direction="file_".$point->id."_".$new_date."_".$n.".pdf";

                    Document::create(
                    [
                      'point_id' => $point->id,
                      'direction' => $direction
                    ]);
                }
                $count++;
            }
            else
            {
                $point=Point::where("id",$dataPoints["point_id"][$key])->update(
                [
                  'description' => $description,
                  'type' => $dataPoints["type"][$key],
                  'agreement' => $dataPoints["agreement"][$key],
                  'post_status' => $dataPoints["post_status"][$key],
                ]);
            }
        }

        $dataAssistance=($request->only(["member_id","assistance"]));

        foreach($dataAssistance["member_id"] as $key => $user_id)
        {
            $user=User::find($user_id);

            if($dataAssistance["assistance"][$key]==1) 
            {
                $user->diaries()->attach($diary_id);
            }
        }

        return redirect()->route("get_diary",["diary_id"=>$diary_id])->with(["message_info"=>"Se ha finalizado exitosamente la pre-agenda"]);
    }

    public function getEditDiary($diary_id)
    {
        $diary=Diary::where("id",$diary_id)->first();

        return response()->json($diary->toArray());
    }

    public function updateDiary(Request $request)
    {
        $diary_id=$request->get("id");
        $description=$request->get("description");
        $event_date=$request->get("event_date");
        $place=$request->get("place");

        $date = new \DateTime("now");
        $date = $date->format("Y-m-d");

        if($event_date<$date)
        {
            return response()->json(['update'=>'0']);
        }

        $diary=Diary::where("id",$diary_id)->first();

        if($diary) 
        {
            $current_agenda=Diary::where("council_id",$diary->council->id)->where("event_date",$event_date)->first();

            if($current_agenda && $current_agenda->id!=$diary->id)
            {
                return response()->json(['update'=>'1']);
            }  
        } 

        $diary=Diary::where("id",$diary_id)->update(["description"=>$description,"event_date"=>$event_date,"place"=>$place,"limit_date"=>\DateTime::createFromFormat("Y-m-d",$event_date)->sub(new \DateInterval("P1D"))]);
        
        $diary_edit=Diary::where("id",$diary_id)->first();
        $diary_edit["event_date"]=\DateTime::createFromFormat("Y-m-d",$diary_edit->event_date)->format("d/m/Y");

        return response()->json(['update'=>$diary_edit]);
    }

    public function getEditPoint($point_id)
    {
        $point=Point::where("id",$point_id)->first();

        return response()->json($point->toArray());
    }

    public function updatePoint(Request $request)
    {
        $point_id=$request->get("id");
        $description=$request->get("description");
        $type=$request->get("type");

        $point=Point::where("id",$point_id)->update(["description"=>$description,"type"=>$type]);
        
        $point_edit=Point::where("id",$point_id)->first();

        return response()->json(['update'=>$point_edit]);
    }

    public function deletePoint($point_id)
    {
        $user=User::getCurrent();

        $point=Point::where("id",$point_id)->first();

        if(!$point) 
        {
            if($user->getCurrentRol()->name=="consejero")
            {
                return redirect()->route("consejero_history_points")->with(["message_info"=>"El punto que trata de eliminar no existe"]);
            }
            elseif($user->getCurrentRol()->name=="presidente")
            {
                return redirect()->route("president_history_points")->with(["message_info"=>"El punto que trata de eliminar no existe"]);
            }
            elseif($user->getCurrentRol()->name=="adjunto")
            {
                return redirect()->route("adjunto_history_points")->with(["message_info"=>"El punto que trata de eliminar no existe"]);
            }
        }

        if($user->getCurrentRol()->name=="consejero" && $point->pre_status!="propuesto" || $point->post_status)
        {
            return redirect()->route("consejero_history_points")->withErrors(["No puede eliminar el punto, ya que no posee el pre-status de propuesto"]);
        }

        $point=Point::where("id",$point_id)->delete();

        if($user->getCurrentRol()->name=="consejero")
        {
            return redirect()->route("consejero_history_points")->with(["message_info"=>"Se ha eliminado exitosamente el punto propuesto"]);
        }
        elseif($user->getCurrentRol()->name=="presidente")
        {
            return redirect()->route("president_history_points")->with(["message_info"=>"Se ha eliminado exitosamente el punto propuesto"]);
        }
        elseif($user->getCurrentRol()->name=="adjunto")
        {
            return redirect()->route("adjunto_history_points")->with(["message_info"=>"Se ha eliminado exitosamente el punto propuesto"]);
        }
    }

    public function getTrash($diary_id)
    {
        $diary=Diary::where("id",$diary_id)->first();

        return view("diary.trash",["diary"=>$diary]);
    }

    public function delete(Request $request)
    {
        $diary_id=$request->get("diary_id");

        Diary::where("id",$diary_id)->delete();
        return redirect()->route("admin_diaries")->with(["message_info"=>"Se ha eliminado la agenda exitosamente"]);
    }

    public function deleteDiary($diary_id)
    {
        Diary::where("id",$diary_id)->delete();
        return redirect()->route("diaries")->with(["message_info"=>"Se ha eliminado la agenda exitosamente"]);
    }

    public function getIndexPoints()
    {
        return view("point.list");
    }


    public function getListPoints()
    {
        $points=Point::all();

        $points_list=[];
        foreach($points as $point)
        {
            if($point->post_status) 
            {
                if($point->post_status=="aprobado") 
                {
                    $post_status="Aprobado";
                }
                elseif($point->post_status=="rechazado") 
                {
                    $post_status="Rechazado";
                }
                elseif($point->post_status=="diferido") 
                {
                    $post_status="Diferido";
                }
                elseif($point->post_status=="diferido_virtual") 
                {
                    $post_status="Diferido virtual";
                }
                elseif($point->post_status=="retirado") 
                {
                    $post_status="Retirado";
                }
                elseif($point->post_status=="presentado") 
                {
                    $post_status="Presentado";
                }
                elseif($point->post_status=="no_presentado") 
                {
                    $post_status="No presentado";
                }
            }
            else
            {
                $post_status="NA";
            }

            if($point->pre_status=="incluido") 
            {
                $pre_status="Incluido";
            }
            elseif($point->pre_status=="propuesto") 
            {
                $pre_status="Propuesto";
            }
            elseif($point->pre_status=="desglosado") 
            {
                $pre_status="Desglosado";
            }

            $points_list[]=[\DateTime::createFromFormat("Y-m-d H:i:s",$point->created_at)->format("d/m/Y"),$point->user->last_name." ".$point->user->first_name,substr($point->description, 0, 25)."...",$point->type=="info"?"Información":"Decisión",$pre_status,$post_status,$point->agreement==null?"NA":substr($point->agreement, 0, 25)."...",'<a href="'.route("point_pdf",["point_id"=>$point->id]).'"><i class="fa fa-print" aria-hidden="true"></i></a> <a href="'.route("get_point",["point_id"=>$point->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a>'];
        }
        return response()->json(['data' => $points_list]);
    }

    public function getPoint($point_id)
    {
        $point=Point::where("id",$point_id)->first();

        return view("point.show",["point"=>$point]);
    }

    public function pdfDiary($diary_id)
    {        
        $diary=Diary::where("id",$diary_id)->first();

        if($diary->status==0) 
        {
            $pdf = PDF::loadView('pdf.diary', compact('diary'));

            return $pdf->download('Pre-Agenda '.$diary->council->name.' '.$diary->event_date.'.pdf');
        }
        else
        {
            $users=$diary->council->users;

            $users_list=[];
            foreach($users as $user)
            {
                $roles="";
                foreach($user->councils as $council)
                {
                    if($council->id==$diary->council->id) 
                    {
                        $roles.=Role::where("id",$council->pivot->role_id)->first()->display_name;
                    }
                }

                $assistance=$user->diaries()->where("id",$diary->id)->first();

                if($assistance) 
                {
                    $assistance="Si asistió";
                }
                else
                {
                    $assistance="No asistió";
                }

                if(!$user->hasRole("admin"))
                {
                    $users_list[]=[$user->last_name." ".$user->first_name,$user->identity_card,$assistance,$user->position->name,$user->phone_number,$roles];
                }
            }

            $pdf = PDF::loadView('pdf.diary', compact('diary','users_list'));

            return $pdf->download('Post-Agenda '.$diary->council->name.' '.$diary->event_date.'.pdf'); 
        }
    }

    public function pdfPoint($point_id)
    {        
        $point=Point::where("id",$point_id)->first();

        $pdf = PDF::loadView('pdf.point', compact('point'));

        return $pdf->download('Punto '.$point->id.' '.$point->diary->council->name.' '.$point->diary->event_date.'.pdf');
    }

    public function getListAssistanceMembers($diary_id)
    {
        $diary=Diary::find($diary_id);

        $users=$diary->council->users;

        $users_list=[];
        foreach($users as $user)
        {
            $roles="";
            foreach($user->councils as $council)
            {
                if($council->id==$diary->council->id) 
                {
                    $roles.=Role::where("id",$council->pivot->role_id)->first()->display_name;
                }
            }

            $assistance=$user->diaries()->where("id",$diary->id)->first();

            if($assistance) 
            {
                $assistance='<i style="color:green;" class="fa fa-check" aria-hidden="true"></i> Si';
            }
            else
            {
                $assistance='<i style="color:red;" class="fa fa-times" aria-hidden="true"></i> No';
            }

            if(!$user->hasRole("admin"))
            {
                $users_list[]=[$user->last_name." ".$user->first_name,$user->identity_card,$assistance,$user->position->name,$user->phone_number,$roles];
            }
        }

        return response()->json(['data' => $users_list]);
    }
}
