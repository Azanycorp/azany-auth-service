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
    /**
     * @param array                $query      The GET parameters
     * @param array                $request    The POST parameters
     * @param array                $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array                $cookies    The COOKIE parameters
     * @param array                $files      The FILES parameters
     * @param array                $server     The SERVER parameters
     * @param string|resource|null $content    The raw body data
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null, private readonly \Illuminate\Foundation\Application $application)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

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

        if ($this->application->environment('production')) {
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
