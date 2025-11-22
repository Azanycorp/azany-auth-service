<?php

namespace App\DTO;

use App\Http\Requests\RegisterRequest;
use Illuminate\Hashing\BcryptHasher;

final readonly class CreateUserDto
{
    public function __construct(
        public RegisterRequest $request,
        public BcryptHasher $bcryptHasher,
        public string $currencyCode
    )
    {}
}
