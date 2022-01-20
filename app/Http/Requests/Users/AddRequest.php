<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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

    public function rules()
    {
        return [
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'name' => 'required',
            'active' => ['value'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El Username es requerido ',
            'username.unique'   => 'El Username está en uso ',
            'name.required'     => 'El nombre y apellido del usuario es requerido',
            'email.required'    => 'El email del usuario es requerido',
            'email.unique'      => 'El email ya esta en uso ',
            'password.required' => 'El password es requerido ',
            'password.min'      => 'El password debe contener al menos 8 caracteres',
        ];
    }
}
