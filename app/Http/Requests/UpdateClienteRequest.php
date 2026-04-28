<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'ci' => 'sometimes|string|unique:clientes,ci,'.$this->cliente->id.'|max:255',
            'email' => 'sometimes|email|unique:clientes,email,'.$this->cliente->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
        ];
    }
}
