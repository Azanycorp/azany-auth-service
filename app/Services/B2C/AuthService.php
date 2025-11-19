<?php

namespace App\Services\B2C;

use App\Models\User;
use App\Enums\UserType;
use App\Enums\SignedUpFrom;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;

class AuthService
{
    use HttpResponse;

    public function __construct(private readonly \Illuminate\Hashing\BcryptHasher $bcryptHasher)
    {}

    public function customerSignUp($request): JsonResponse
    {
        try {
            $currencyCode = currencyCodeByCountryId($request->country_id);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'type' => UserType::B2C_CUSTOMER->value,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'default_currency' => $currencyCode,
                'email_verified_at' => null,
                'is_verified' => true,
                'password' => $this->bcryptHasher->make($request->password),
                'signed_up_from' => SignedUpFrom::AZANY_B2C->value,
            ]);

            return $this->success($user, 'Account created successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 400);
        }
    }
}
