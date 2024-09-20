<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'nombre' => 'required|string|max:30',
            'telefono' => 'nullable|digits:9',
            'correo_institucional' => 'required|string|email|max:100|unique:usuario,correo_institucional',
            'contrasenia' => 'required|string|min:8'
        ];
    }
}
