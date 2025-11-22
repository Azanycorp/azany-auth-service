<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\CreateUserDto;
use App\Models\User;
use App\Enum\UserStatus;

final readonly class CreateUserAction
{
    /**
     * Execute the action.
     */
    public function handle(CreateUserDto $dto): User
    {
        return User::create([
            'first_name' => $dto->request->first_name,
            'last_name' => $dto->request->last_name,
            'email' => $dto->request->email,
            'email_verified_at' => null,
            'is_verified' => false,
            'type' => $dto->request->type,
            'country_id' => $dto->request->country_id,
            'state_id' => $dto->request->state_id,
            'default_currency' => $dto->currencyCode,
            'password' => $dto->bcryptHasher->make($dto->request->password),
            'signed_up_from' => $dto->request->signed_up_from,
            'status' => UserStatus::PENDING,
        ]);
    }
}
