<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
        return [
			'nombres' => 'required|string',
			'apellido_paterno' => 'required|string',
			'apellido_materno' => 'string',
			'direccion_domiciliaria' => 'string',
			'correo_electronico' => 'required|string',
			'contrasena' => 'required|string',
			'telefono' => 'string',
			'ci' => 'string',
			'estado' => 'required|string',
			'rol' => 'required|string',
        ];
    }
}
