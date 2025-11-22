<?php

namespace App\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Http\Requests\B2CCustomerSignupRequest;
use App\Services\B2C\AuthService;
use Illuminate\Http\Request;

class B2CController extends Controller
{
    public function __construct(
        protected readonly AuthService $authService
    )
    {}

    public function customerSignUp(B2CCustomerSignupRequest $request, CreateUserAction $createUserAction)
    {
        return $this->authService->customerSignUp($request, $createUserAction);
    }
}
