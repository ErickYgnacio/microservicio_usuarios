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
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'nombre' => 'required|string|max:30',
            'telefono' => 'nullable|digits:9',
            'correo_institucional' => 'required|string|email|max:100',
            'contrasenia' => 'required|string|min:8',
            'categoria' => 'nullable|string',
            'seguro' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'apellido_paterno.required' => 'El apellido paterno es requerido',
            'apellido_paterno.string' => 'El apellido paterno debe ser una cadena de caracteres',
            'apellido_paterno.max' => 'El apellido paterno no debe exceder los 50 caracteres',
            'apellido_materno.required' => 'El apellido materno es requerido',
            'apellido_materno.string' => 'El apellido materno debe ser una cadena de caracteres',
            'apellido_materno.max' => 'El apellido materno no debe exceder los 50 caracteres',
            'nombre.required' => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe ser una cadena de caracteres',
            'nombre.max' => 'El nombre no debe exceder los 30 caracteres',
            'telefono.digits' => 'El teléfono debe tener 9 dígitos',
            'correo_institucional.required' => 'El correo institucional es requerido',
            'correo_institucional.string' => 'El correo institucional debe ser una cadena de caracteres',
            'correo_institucional.email' => 'El correo institucional debe ser un correo electrónico',
            'correo_institucional.max' => 'El correo institucional no debe exceder los 100 caracteres',
            'contrasenia.required' => 'La contraseña es requerida',
            'contrasenia.string' => 'La contraseña debe ser una cadena de caracteres',
            'contrasenia.min' => 'La contraseña debe tener al menos 8 caracteres',
            'categoria.string' => 'La categoría debe ser una cadena de caracteres',
            'seguro.string' => 'El seguro debe ser una cadena de caracteres'
        ];
    }
}
