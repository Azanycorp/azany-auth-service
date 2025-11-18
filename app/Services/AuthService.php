<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\User;
use App\Models\Verify;
use App\Enum\UserStatus;
use App\Models\ActivityLog;
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
    use HttpResponses;

    public function register($request)
    {
         User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'status' => UserStatus::PENDING,
            'password' => bcrypt($request->password),
        ]);

        return $this->successResponse(Response::HTTP_CREATED);
    }

    public function login($request)
    {
        $user = User::select(['email_verified_at','email', 'password', 'status'])->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials.', [], Response::HTTP_UNAUTHORIZED);
        }

        if ($user->status !== UserStatus::ACTIVE) {
            return $this->errorResponse("User account is not active. Please contact support.", [], 403);
        }

        if (is_null($user->email_verified_at)) {
            $user->sendVerificationEmail();
            return $this->errorResponse('You need to verify your account. Please check your email for instructions.', [], Response::HTTP_BAD_REQUEST);
        }

        return $this->successResponse($user);
    }


}
