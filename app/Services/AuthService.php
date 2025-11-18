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

        return $this->successResponse('Registration successful. Kindly check your inbox for instructions on how to verify your account. Thanks.', [], Response::HTTP_CREATED);
    }

    // public function login($request)
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if (! $user || ! Hash::check($request->password, $user->password)) {
    //         return $this->errorResponse('Invalid credentials.', [], Response::HTTP_UNAUTHORIZED);
    //     }

    //     if ($user->status !== UserStatus::ACTIVE) {
    //         return $this->errorResponse("User account is not active. Please contact support.", [], 403);
    //     }

    //     if (is_null($user->email_verified_at)) {
    //         $user->sendVerificationEmail();
    //         return $this->errorResponse('You need to verify your account. Please check your email for instructions.', [], Response::HTTP_BAD_REQUEST);
    //     }

    //     if ($user->two_factor_enabled) {
    //         $verificationCode = mt_rand(1000, 9999);
    //         $expiry = now()->addMinutes(30);

    //         $user->update([
    //             'verification_code' => $verificationCode,
    //             'verification_code_expire_at' => $expiry,
    //         ]);

    //         Mail::to($user->email)->send(new TwoFactorCodeMail($user, $verificationCode));

    //         return $this->successResponse('2FA code sent. Please verify.', [
    //             'email' => $user->email,
    //             '2fa_required' => true
    //         ], Response::HTTP_ACCEPTED);
    //     }

    //     return $this->successResponse(200);
    // }

}
