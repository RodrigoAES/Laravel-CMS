<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ];
    }

    public function messages() {
        return [
            'name.required' => 'O campo nome é Obrigatório',
            'name.string' => 'Formato de nome não aceito',
            'name.max' => 'O nome deve conterno maxímo 255 caracteres',
            
            'email.required' => 'O campo e-mail é obrigatório',
            'email.string' => 'Formato de e-mail não aceito',
            'email.email' => 'O campo e-mail deve conter um formato de e-mail válido',
            'email.max' => 'O campo e-mail deve conter no máximo 255 caracteres',
            'email.unique' => 'E-mail já está sendo utilizado por outra conta',

            'password.required' => 'O campo senha é obrigatório',
            'password.string' => 'Formato de senha inválido',
            'password.min' => 'A senha deve conter no minímo 4 caracteres',
            'password.confirmed' => 'As duas senhas não coincidem'
        ];
    }
}
