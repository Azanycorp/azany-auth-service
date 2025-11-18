<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Verify;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\HttpResponses;
use App\Http\Requests\CodeRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasscodeRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\ResendEmailRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\ProfilepdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\VerifyPasscodeRequest;
use App\Http\Requests\ProfilePhotoUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AVCAuthenticationController extends Controller
{
    use HttpResponses;
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }
    

}
