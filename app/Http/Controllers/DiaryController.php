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

class DiaryController extends Controller
{
    public function getLimitedIndex()
    {
        return view("diary.list_limited");
    }

    public function getListLimited()
    {
        $diaries=Diary::get();

        $diaries_list=[];
        foreach($diaries as $diary)
        {
            $diaries_list[]=[$diary->council->name,$diary->council->president==null?"No asignado":$diary->council->president->last_name." ".$diary->council->president->first_name,\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y"),'<a href="'.route("get_diary",["diary_id"=>$diary->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a>'];
        }
        return response()->json(['data' => $diaries_list]);
    }

    public function getIndex()
    {
        return view("diary.list");
    }

    public function getList()
    {
        $diaries=Diary::get();

        $diaries_list=[];
        foreach($diaries as $diary)
        {
            $diaries_list[]=[$diary->council->name,$diary->council->president==null?"No asignado":$diary->council->president->last_name." ".$diary->council->president->first_name,\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y"),'<a href="'.route("get_diary",["diary_id"=>$diary->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a>'];
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

        if($user->hasRole("admin"))
        {
            $councils=Council::orderBy("name","asc")->get();
        }
        else
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

        if(count($councils)==0 && $user->hasRole("admin"))
        {
            return redirect()->route("admin_councils_create")->withErrors(["Primero debes registrar un consejo como mínimo, para poder registrar o convocar una nueva agenda"]);
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
        $date=gmdate("Y-m-d");

        if($event_date<$date)
        {
            return redirect()->back()->withErrors(["No puede registrar o convocar una agenda en una fecha que ya pasó"]);
        }

        $dataPoints=($request->only(["description_point","type","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));   

        if(!isset($dataPoints["description_point"]))
        {
            return redirect()->back()->withErrors(["No puede registrar o convocar una agenda sin agregar un punto como mínimo"]);
        }
        else
        {
            $data=($request->only(["council_id","description","place","event_date"]));
            
            if($event_date==$date)
            {
                $data["limit_date"]=$event_date;
            }
            else
            {
                $data["limit_date"]=\DateTime::createFromFormat("Y-m-d",$event_date)->sub(new \DateInterval("P1D"))->format("Y-m-d");
            }

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

                $new_date=gmdate("d_m_Y");

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

            $council=Council::where("id",$data["council_id"])->first();

            $users=$council->users;

            foreach ($users as $user) 
            {
                if($user->status && $user->validate) 
                {
                    \Mail::send('emails.user_invitation', ["user"=>$user,"council"=>$council,"diary"=>$diary], function($message) use($user,$council)
                    {
                        $message->subject("Invitación del ".$council->name);
                        $message->to($user->email,$user->first_name);
                    });
                }
            }

            if($user->hasRole("admin"))
            {
                return redirect()->route("admin_diaries")->with(["message_info"=>"Se ha registrado la agenda exitosamente con sus puntos"]);
            }
            else
            {
                return redirect()->route("diaries")->with(["message_info"=>"Se ha registrado la agenda exitosamente con sus puntos"]);
            }
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

        $diaries_list=[];
        foreach($user->councils as $council) 
        {
            foreach($council->diaries->where("limit_date",">=",gmdate("Y-m-d")) as $diary)
            {
                $diaries_list[]=[$diary->id, $council->name." - ".\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")];
            }
        }

        return response()->json(['data' => $diaries_list]);
    }

    public function SecretaryProposePoints(Request $request)
    {
        $dataPoints=($request->only(["user_id","diary_id","description_point","type","attached_document_one","attached_document_two","attached_document_three","attached_document_four"]));   

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
                  'user_id' => $dataPoints["user_id"],
                  'diary_id' => $diary->id,
                  'title' => "punto_".$key,
                  'description' => $description,
                  'type' => $dataPoints["type"][$key],
                  'pre_status' => "propuesto"
                ]);

                $new_date=gmdate("d_m_Y");

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
            
            return redirect()->route("diaries")->with(["message_info"=>"Se han propuesto exitosamente los puntos"]);
        }
    }

    public function getPoints()
    {
        return view("point.president_points");
    }

    public function evaluatePoint($point_id,$evaluation)
    {
        $point=Point::where("id",$point_id)->update(["pre_status"=>$evaluation]);

        if($evaluation=="incluido") 
        {
            return redirect()->route("get_presidente_points")->with(["message_info"=>"Punto incluído exitosamente en la agenda"]);
        }
        else
        {
            return redirect()->route("get_presidente_points")->withErrors(["Punto desglosado exitosamente de la agenda"]);
        }

    }

    public function getConsejeroProposePoints()
    {
        $user=User::getCurrent();

        $diaries_list=[];
        foreach($user->councils as $council) 
        {
            if($user->getCurrentRol()->id===$council->pivot->role_id)
            {
                foreach($council->diaries->where("limit_date",">=",gmdate("Y-m-d")) as $diary)
                {
                    $diaries_list[]=[$diary->id, $council->name." - ".\DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")];
                }
            }
        }

        if(count($diaries_list)==0)
        {
            return redirect()->route("consejero_dashboard")->withErrors(["No se ha registrado ninguna agenda para proponer nuevos puntos"]);
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
                  'pre_status' => "propuesto"
                ]);

                $new_date=gmdate("d_m_Y");

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
}