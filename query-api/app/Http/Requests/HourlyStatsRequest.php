<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HourlyStatsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "event_type" => ['nullable', 'string', "max:255"],
        ];
    }
}
