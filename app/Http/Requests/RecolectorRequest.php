<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecolectorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $recolectorId = $this->route('recolectore'); // ID del recolector en edición

        return [
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'ci' => 'required|string|max:20|unique:usuarios,ci,' . $recolectorId . ',id_usuario',
            'licencia_conducir' => 'nullable|string|max:50',
            'genero' => 'nullable|in:Masculino,Femenino,Otro',
            'correo' => 'required|email|max:100|unique:usuarios,correo,' . $recolectorId . ',id_usuario',
            'telefono' => 'nullable|string|max:20',
            'direccion_domicilio' => 'nullable|string|max:255',
            'contrasena' => $this->isMethod('post') ? 'required|string|min:6' : 'nullable|string|min:6',
            'estado' => 'nullable|in:Activo,Inactivo',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nombres.required' => 'El campo nombres es obligatorio',
            'apellidos.required' => 'El campo apellidos es obligatorio',
            'ci.required' => 'El campo CI es obligatorio',
            'ci.unique' => 'Este CI ya está registrado',
            'correo.required' => 'El campo correo es obligatorio',
            'correo.email' => 'Ingrese un correo electrónico válido',
            'correo.unique' => 'Este correo ya está registrado',
            'contrasena.required' => 'El campo contraseña es obligatorio',
            'contrasena.min' => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
