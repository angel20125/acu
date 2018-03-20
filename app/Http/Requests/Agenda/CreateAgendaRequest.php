<?php

namespace App\Http\Requests\Agenda;

use Illuminate\Foundation\Http\FormRequest;

class CreateAgendaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status'            => 'integer|required|in:1,2',
            'attached_document' => 'file|max:10240|mimes:pdf',
            'description'       => 'string|required',
            'event_date'        => 'date|required',
        ];
    }

    public function messages()
    {
        return [
            'attached_document.mimes' => 'El documento adjunto debe ser un archivo de tipo: pdf',
            'description.required' => 'Olvidaste agregar la descripción',
            'event_date.required' => 'Olvidaste agregar la fecha donde se va a tratar la agenda',
        ];
    }
}
