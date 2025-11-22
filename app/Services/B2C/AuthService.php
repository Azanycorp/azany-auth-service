<?php

declare(strict_types=1);

namespace App\Services\B2C;

use App\DTO\CreateUserDto;
use App\Enum\UserType;
use App\Enum\SignedUpFrom;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Hashing\BcryptHasher;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    use HttpResponse;

    public function __construct(private readonly BcryptHasher $bcryptHasher)
    {}

    public function customerSignUp($request, $createUserAction): JsonResponse
    {
        try {
            $currencyCode = currencyCodeByCountryId($request->country_id);

            $user = $createUserAction->handle(
                new CreateUserDto(
                    $request,
                    $this->bcryptHasher,
                    UserType::B2C_CUSTOMER->value,
                    $currencyCode,
                    SignedUpFrom::AZANY_B2C->value
                )
            );

            return $this->success($user, 'Account created successfully', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
