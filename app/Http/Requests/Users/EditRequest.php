<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
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
            'username' => 'required|unique:users,username,' . $this->user_id,
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => ['same:confirm-password'],
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required'   => 'El nombreusuario es requerido!',
            'username.unique'   => 'El nombreusuario ya existe!',
            'email.unique'   => 'El email del usuario es requerido!',
            'email.required'   => 'El email ya existe!',
            'name.required'   => 'El nombre del usuario es requerido!',
            'password.required' => 'El password es requerido ',
            'password.same'     => 'Las claves no coinciden',
            'password.min'      => 'El password debe contener al menos 8 caracteres',
        ];
    }
}
