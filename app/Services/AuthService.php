<?php

namespace App\Services;

use App\DTO\CreateUserDto;
use App\Enum\UserStatus;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    use HttpResponse;

    public function __construct(
        private readonly BcryptHasher $bcryptHasher
    ) {}

    public function register($request, $createUserAction): JsonResponse
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

    public function login($request): JsonResponse
    {
        $user = User::where('email', $request->string('email'))->first();

        if (! $user) {
            return $this->error(null, 'Account not found.', 401);
        }

        if (! $user->is_verified) {
            return $this->error([
                'is_verified' => false,
            ], 'Your account is not verified.', 403);
        }

        if ($user->status !== UserStatus::ACTIVE) {
            return $this->error([
                'status' => $user->status,
            ], 'User account is not active. Please contact support.', 403);
        }

        if ($user->email_verified_at === null) {
            return $this->error([
                'status' => $user->status,
                'email_verified' => false,
            ], 'You need to verify your account. Please check your email for instructions.', 403);
        }

        return $this->success($user, 'Login successful');
    }

    public function verifyCode($request): JsonResponse
    {
        $user = User::where('email', $request->string('email'))->first();

        if (! $user) {
            return $this->error(null, 'User Record not found.', Response::HTTP_NOT_FOUND);
        }

        $user->update([
            'email_verified_at' => now(),
            'is_verified' => true,
            'status' => UserStatus::ACTIVE,
        ]);

        return $this->success(null, 'Email verified successfully.');
    }

    public function updateAccount($request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return $this->error(null, 'User Record not found.', Response::HTTP_NOT_FOUND);
        }

        $user->update($request->safe()->except(['email']));

        return $this->success(null, 'Account updated successfully.');
    }

    public function deleteAccount($request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return $this->error(null, 'User Record not found.', 404);
        }

        $user->update([
            'email' => "deleted_{$user->id}_{$user->email}",
        ]);

        $user->delete();

        return $this->success(null, 'Account deleted successfully.');
    }

    public function bulkDeleteAccounts($request): JsonResponse
    {
        $validated = $request->validate([
            'emails' => ['required', 'array', 'min:1', 'max:100'],
            'emails.*' => ['required', 'email'],
        ]);

        $users = User::whereIn('email', $validated['emails'])->get()->keyBy('email');

        $deleted = [];
        $notFound = [];

        foreach ($validated['emails'] as $email) {
            $user = $users->get($email);

            if (! $user) {
                $notFound[] = $email;

                continue;
            }

            $user->update([
                'email' => "deleted_{$user->id}_{$user->email}",
            ]);
            $user->delete();

            $deleted[] = $email;
        }

        if (empty($deleted)) {
            return $this->error([
                'deleted' => $deleted,
                'not_found' => $notFound,
            ], 'No matching user records found.', Response::HTTP_NOT_FOUND);
        }

        return $this->success([
            'deleted' => $deleted,
            'not_found' => $notFound,
        ], 'Accounts deleted successfully.');
    }
}
