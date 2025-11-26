<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonanteRequest extends FormRequest
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
        $rules = [
			'nombre' => 'required|string|max:150',
			'tipo' => 'nullable|string|in:persona,empresa',
			'email' => 'nullable|email|max:100',
			'telefono' => 'nullable|string|max:20',
			'direccion' => 'nullable|string',
        ];
        
        // Solo requerir id_donante cuando se está actualizando
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['id_donante'] = 'required';
            $rules['password'] = 'nullable|string|min:6';
        } else {
            // En creación, password es requerido
            $rules['password'] = 'required|string|min:6';
        }
        
        return $rules;
    }
}
