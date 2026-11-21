<?php

namespace App\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request, CreateUserAction $createUserAction): JsonResponse
    {
        return $this->authService->register($request, $createUserAction);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function verifyCode(Request $request): JsonResponse
    {
        return $this->authService->verifyCode($request);
    }

    public function updateAccount(UpdateAccountRequest $request): JsonResponse
    {
        return $this->authService->updateAccount($request);
    }

    public function deleteAccount(Request $request): JsonResponse
    {
        return $this->authService->deleteAccount($request);
    }    
}
