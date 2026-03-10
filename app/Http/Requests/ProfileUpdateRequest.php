<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'sexe' => ['nullable', 'string', 'in:M,F,Autre'],
            'pays' => ['nullable', 'string', 'max:100'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'adresse_livraison' => ['nullable', 'string', 'max:500'],
        ];
    }
}
