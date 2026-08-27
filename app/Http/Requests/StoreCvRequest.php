<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCvRequest extends FormRequest
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
            'template' => ['required', 'in:classic,modern'],

            'personal.first_name' => ['required', 'string', 'max:100'],
            'personal.last_name' => ['required', 'string', 'max:100'],
            'personal.title' => ['nullable', 'string', 'max:150'],
            'personal.email' => ['required', 'email', 'max:255'],
            'personal.phone' => ['nullable', 'string', 'max:50'],
            'personal.city' => ['nullable', 'string', 'max:100'],
            'personal.summary' => ['nullable', 'string', 'max:1000'],

            'experience' => ['nullable', 'array'],
            'experience.*.company' => ['nullable', 'string', 'max:150'],
            'experience.*.position' => ['nullable', 'string', 'max:150'],
            'experience.*.period' => ['nullable', 'string', 'max:100'],
            'experience.*.description' => ['nullable', 'string', 'max:1000'],

            'education' => ['nullable', 'array'],
            'education.*.school' => ['nullable', 'string', 'max:150'],
            'education.*.field' => ['nullable', 'string', 'max:150'],
            'education.*.period' => ['nullable', 'string', 'max:100'],

            'skills' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get the validated CV data shaped for rendering, with empty
     * experience/education rows and blank skills dropped.
     */
    public function cvData(): array
    {
        $data = $this->validated();

        $data['experience'] = collect($data['experience'] ?? [])
            ->filter(fn (array $row) => array_filter($row) !== [])
            ->values()
            ->all();

        $data['education'] = collect($data['education'] ?? [])
            ->filter(fn (array $row) => array_filter($row) !== [])
            ->values()
            ->all();

        $data['skills'] = collect(explode(',', $data['skills'] ?? ''))
            ->map(fn (string $skill) => trim($skill))
            ->filter()
            ->values()
            ->all();

        return $data;
    }
}
