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
			'id_usuario' => 'required',
			'nombres' => 'required|string',
			'apellidos' => 'required|string',
			'ci' => 'required|string',
			'foto_ci' => 'string',
			'licencia_conducir' => 'string',
			'foto_licencia' => 'string',
			'genero' => 'string',
			'correo' => 'required|string',
			'telefono' => 'string',
			'direccion_domicilio' => 'string',
			'contrasena' => 'required|string',
			'estado' => 'string',
			'entidad_pertenencia' => 'string',
			'tipo_sangre' => 'string',
        ];
    }
}
