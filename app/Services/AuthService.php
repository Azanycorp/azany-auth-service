<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\User;
use App\Models\Verify;
use App\Enum\UserStatus;
use App\Models\ActivityLog;
use App\Traits\HttpResponse;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use App\Mail\TwoFactorCodeMail;
use App\Models\AccountDeletion;
use App\Traits\CreateActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Api\LoginResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthService
{
    use HttpResponse;
    public function __construct(private readonly \Illuminate\Contracts\Hashing\Hasher $hasher, private readonly \Illuminate\Hashing\BcryptHasher $bcryptHasher) {}

    public function register($request)
    {
        try {
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'country_id' => $request->country_id,
                'status' => UserStatus::PENDING,
                'password' => $this->bcryptHasher->make($request->password),
            ]);

            return $this->success(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 400);
        }
    }

    public function login($request)
    {

        $user = User::select(['email_verified_at', 'email', 'password', 'status'])->where('email', $request->email)->first();

        if (! $user || ! $this->hasher->check($request->password, $user->password)) {
            return $this->error(null, 'Invalid credentials.');
        }

        if ($user->status !== UserStatus::ACTIVE) {
            return $this->error(null, "User account is not active. Please contact support.");
        }

        if (is_null($user->email_verified_at)) {
            return $this->error(null, 'You need to verify your account. Please check your email for instructions.');
        }

        return $this->success($user);
    }
}
