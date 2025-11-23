<?php

namespace App\Services;

use App\DTO\CreateUserDto;
use App\Models\User;
use App\Enum\UserStatus;
use App\Traits\HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use HttpResponse;

    public function __construct(
        private readonly Hasher $hasher,
        private readonly BcryptHasher $bcryptHasher
    ) {}

    public function register($request, $createUserAction)
    {
        try {
            $currencyCode = currencyCodeByCountryId($request->integer('country_id'));

            $user = $createUserAction->handle(
                new CreateUserDto(
                    $request,
                    $this->bcryptHasher,
                    $currencyCode
                )
            );

            return $this->success($user, 'Account created successfully.', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 400);
        }
    }

    public function login($request)
    {
        $user = User::where('email', $request->string('email'))->first();

        if (! $user) {
            return $this->error(null, 'Account not found.', 401);
        }

        if (! $user->is_verified) {
            return $this->error(null, 'Your account is not verified.', 403);
        }

        if ($user->status !== UserStatus::ACTIVE) {
            return $this->error(null, 'User account is not active. Please contact support.', 403);
        }

        if ($user->email_verified_at === null) {
            return $this->error(null, 'You need to verify your account. Please check your email for instructions.', 403);
        }

        return $this->success($user, 'Login successful');
    }

    public function verifyCode($request)
    {
        $user = User::where('email', $request->string('email'))->first();

        if (! $user) {
            return $this->error(null, 'User Record not found.', Response::HTTP_NOT_FOUND);
        }

        $user->update([
            'email_verified_at' => now(),
            'is_verified' => true,
            'status' => UserStatus::ACTIVE
        ]);

        return $this->success(null, 'Email verified successfully.');
    }
}
