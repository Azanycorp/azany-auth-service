<?php

namespace App\Http\Controllers;

use App\Services\B2C\AuthService;
use Illuminate\Http\Request;

class B2CController extends Controller
{
    public function __construct(
        protected readonly AuthService $authService
    )
    {}

    public function customerSignUp(Request $request)
    {
        return $this->authService->customerSignUp($request);
    }
}
