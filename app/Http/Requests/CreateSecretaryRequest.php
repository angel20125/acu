<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSecretaryRequest extends FormRequest
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
            'identity_card' => 'required|numeric|unique:users',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'phone_number' => 'required|numeric',
            'email' => 'required|email|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'identity_card.required' => 'Olvidaste agregar la cédula de identidad',
            'identity_card.numeric' => 'La cédula de identidad debe componerse solo de dígitos numéricos',
            'identity_card.unique' => 'Ya existe un usuario con esa cédula de identidad',
            'first_name.required' => 'Olvidaste agregar el nombre',
            'first_name.alpha' => 'El nombre debe componerse solo de caracteres alfabéticos',
            'last_name.required' => 'Olvidaste agregar el apellido',
            'last_name.alpha' => 'El apellido debe componerse solo de caracteres alfabéticos',
            'phone_number.required' => 'Olvidaste agregar el número de teléfono',
            'phone_number.numeric' => 'El número de teléfono debe componerse solo de dígitos numéricos',
            'email.required' => 'Olvidaste agregar el correo electrónico',
            'email.email' => 'El correo electrónico ingresado es inválido',
            'email.unique' => 'Ya existe un usuario con ese correo electrónico',
        ];
    }
}
