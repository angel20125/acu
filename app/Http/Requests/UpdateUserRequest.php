<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'identity_card' => 'required|numeric',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'identity_card.required' => 'Olvidaste agregar la cédula de identidad',
            'identity_card.numeric' => 'La cédula de identidad debe componerse solo de dígitos numéricos',
            'first_name.required' => 'Olvidaste agregar el nombre',
            'first_name.alpha' => 'El nombre debe componerse solo de caracteres alfabéticos',
            'last_name.required' => 'Olvidaste agregar el apellido',
            'last_name.alpha' => 'El apellido debe componerse solo de caracteres alfabéticos',
            'phone_number.required' => 'Olvidaste agregar el número de teléfono',
            'phone_number.numeric' => 'El número de teléfono debe componerse solo de dígitos numéricos',
            'email.required' => 'Olvidaste agregar el correo electrónico',
            'email.email' => 'El correo electrónico ingresado es inválido',
        ];
    }
}
