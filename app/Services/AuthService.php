<?php

namespace App\Services;

use App\DTO\CreateUserDto;
use App\Models\User;
use App\Enum\UserStatus;
use App\Traits\HttpResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\BcryptHasher;

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
            $currencyCode = currencyCodeByCountryId($request->country_id);

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
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return $this->error(null, 'Account not found.', 401);
        }

        if (! $this->hasher->check($request->password, $user->password)) {
            return $this->error(null, 'Invalid credentials.', 401);
        }

        if ($user->status !== UserStatus::ACTIVE) {
            return $this->error(null, 'User account is not active. Please contact support.', 403);
        }

        if (is_null($user->email_verified_at)) {
            return $this->error(null, 'You need to verify your account. Please check your email for instructions.', 403);
        }

        return $this->success($user, 'Login successful.');
    }

    public function verifyCode($request)
    {
        $user = User::where('email', $request->email)->first();

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
