<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use App\Enum\UserType;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'type' => ['required', 'string', Rule::in(UserType::values())],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'password' => ['required', 'string', Password::defaults()],
            'signed_up_from' => ['required', 'string'],
        ];

        if (App::environment('production')) {
            $rules['email'][] = function ($attribute, $value, $fail) {
                $blockedDomains = config('disposableemail.domains', []);

                $domain = strtolower(trim(Str::after($value, '@')));

                if (in_array($domain, $blockedDomains, true)) {
                    $fail('Disposable or test email addresses are not allowed.');
                }
            };
        }

        return $rules;
    }
}
