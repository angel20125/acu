<?php

namespace App\Http\Requests\Diary;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiaryRequest extends FormRequest
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
            'place'       => 'required',
            'description' => 'required',
            'event_date'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'place.required' => 'Olvidaste agregar el lugar donde se tratará la agenda',
            'description.required' => 'Olvidaste agregar la descripción',
            'event_date.required' => 'Olvidaste agregar la fecha donde se tratará la agenda',
        ];
    }
}
