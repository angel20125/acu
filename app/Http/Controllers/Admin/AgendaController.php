<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Http\Requests\Agenda\CreateAgendaRequest;
use App\Http\Requests\Agenda\DeleteAgendaRequest;
use App\Http\Requests\Agenda\UpdateAgendaRequest;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::latest('created_at')->get();
        return response()->json(['data' => $agendas]);
    }

    public function show(DeleteAgendaRequest $request, $agendaId)
    {
        $agenda = Agenda::findOrFail($request->id);
        return response()->json(['data' => $agenda]);
    }

    public function getCreate()
    {
        return view('agenda.create');
    }

    public function create()
    {
        return view('agenda.create');
    }

    public function store(CreateAgendaRequest $request)
    {
        $newAgenda = Agenda::create($request->all());

        return $newAgenda ? [
            'success' => true,
            'agenda' => $newAgenda
        ] : [
            'error' => 'Agenda no pudo ser creada'
        ];
    }

    public function update(UpdateAgendaRequest $request)
    {
        $agenda = Agenda::where('id','=',$request->id)->first();

        if ($agenda == null) {
            return response()->json(['error' => 'La agenda no se encontró'], 404);
        }

        $agenda->update($request->all());

        return [
            'success' => true,
            'agenda' => $agenda
        ];
    }

    public function delete(DeleteAgendaRequest $request)
    {
        $agenda = Agenda::findOrFail($request->id);

        return [
            'deleted_agenda' => $agenda,
            'success' => (Agenda::destroy($request->id) > 0)
        ];
    }

}
