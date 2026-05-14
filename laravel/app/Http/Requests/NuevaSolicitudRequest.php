<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class NuevaSolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion'   => 'required|string|min:10',
            'tipo_servicio' => 'required|in:estandar,urgente',
            'fecha_servicio' => [
                'required',
                'date',
                'after:now',
                function ($attribute, $value, $fail) {
                    $fechaServicio = Carbon::parse($value);
                    $ahora = Carbon::now();
                    $diferenciaHoras = $ahora->diffInHours($fechaServicio, false);

                    if ($this->input('tipo_servicio') === 'estandar' && $diferenciaHoras < 48) {
                        $fail('El servicio estándar debe solicitarse con al menos 48 horas de antelación.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'descripcion.required'    => 'La descripción es obligatoria.',
            'descripcion.min'         => 'La descripción debe tener al menos 10 caracteres.',
            'tipo_servicio.required'  => 'El tipo de servicio es obligatorio.',
            'tipo_servicio.in'        => 'El tipo de servicio debe ser estándar o urgente.',
            'fecha_servicio.required' => 'La fecha de servicio es obligatoria.',
            'fecha_servicio.date'     => 'La fecha de servicio no tiene un formato válido.',
            'fecha_servicio.after'    => 'La fecha de servicio debe ser futura.',
        ];
    }
}