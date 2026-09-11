<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:190'],
            'bio' => ['required', 'string', 'max:1000'],
            'full_bio' => ['nullable', 'string', 'max:10000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'location' => ['nullable', 'string', 'max:190'],
            'phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:190'],
            'website' => ['nullable', 'url', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:80'],
            'career_goals' => ['nullable', 'string', 'max:5000'],
            'developer_journey' => ['nullable', 'string', 'max:10000'],
            'languages' => ['nullable', 'string', 'max:2000'],
            'interests' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
