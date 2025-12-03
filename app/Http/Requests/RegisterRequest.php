<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use App\Enum\UserType;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'alpha_dash', 'max:255'],
            'last_name' => ['required', 'string', 'alpha_dash', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'type' => ['required', 'string', Rule::in(UserType::values())],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'password' => ['required', 'string', Password::defaults()],
            'signed_up_from' => ['required', 'string'],
        ];
    }
}
