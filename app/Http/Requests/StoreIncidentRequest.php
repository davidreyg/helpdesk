<?php

namespace App\Http\Requests;

use App\Enums\AttentionTypeEnum;
use App\Enums\PriorityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIncidentRequest extends FormRequest
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
            'attention_type' => ['required', Rule::enum(AttentionTypeEnum::class)],
            'company_id' => 'required|exists:companies,id',
            'priority' => ['required', Rule::enum(PriorityEnum::class)],
            'description' => 'required|string|max:300',
            'files' => 'nullable|array',  // Validar que 'files' es un array
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120', // Validación de cada archivo
        ];
    }
}
