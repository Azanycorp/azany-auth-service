<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verify;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\HttpResponses;
use App\Http\Requests\CodeRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthenticationController extends Controller
{
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
