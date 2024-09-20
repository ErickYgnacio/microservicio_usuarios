<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'apellido_paterno' => 'string|max:50',
            'apellido_materno' => 'string|max:50',
            'nombre' => 'string|max:30',
            'telefono' => 'digits:9',
            'correo_institucional' => 'string|email|max:100|unique:usuario,correo_institucional',
            'contrasenia' => 'string|min:8'
        ];
    }
}
