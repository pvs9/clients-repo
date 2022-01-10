<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page' => [
                'integer',
                'min:1',
            ],
            'query' => [
                'string',
            ],
            'sort_by' => [
                'string',
                Rule::in(['id', 'name', 'manager.name', 'updated_at']),
            ],
        ];
    }
}
