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
        $usuario = $this->route('usuario');
        $usuarioId = $usuario ? $usuario->id_usuario : null;
        
        $rules = [
			'nombres' => 'required|string|max:100',
			'apellidos' => 'required|string|max:150',
			'ci' => 'required|string|max:20|unique:usuarios,ci' . ($usuarioId ? ',' . $usuarioId . ',id_usuario' : ''),
			'foto_ci' => 'nullable|string',
			'licencia_conducir' => 'nullable|string|max:50',
			'foto_licencia' => 'nullable|string',
			'genero' => 'nullable|string|in:Masculino,Femenino,Otro',
			'correo' => 'required|email|max:100|unique:usuarios,correo' . ($usuarioId ? ',' . $usuarioId . ',id_usuario' : ''),
			'telefono' => 'nullable|string|max:20',
			'direccion_domicilio' => 'nullable|string',
			'contrasena' => 'required|string',
			'estado' => 'nullable|string|in:Activo,Inactivo',
			'entidad_pertenencia' => 'nullable|string|max:150',
			'tipo_sangre' => 'nullable|string|max:5',
			'id_rol' => 'nullable|integer|exists:roles,id_rol',
        ];
        
        // Solo requerir id_usuario cuando se está actualizando
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['id_usuario'] = 'required';
        }
        
        return $rules;
    }
}
