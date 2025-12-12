<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Actions\CreateUserAction;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\UpdateAccountRequest;

class AuthenticationController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request, CreateUserAction $createUserAction)
    {
        return $this->authService->register($request, $createUserAction);
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function verifyCode(Request $request)
    {
        return $this->authService->verifyCode($request);
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        return $this->authService->updateAccount($request);
    }

    public function deleteUserAccount(DeleteAccountRequest $request)
    {
        return $this->authService->deleteUserAccount($request);
    }
}
