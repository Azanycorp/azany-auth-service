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
            'first_name' => $dto->request->string('first_name'),
            'last_name' => $dto->request->string('last_name'),
            'email' => $dto->request->string('email'),
            'email_verified_at' => $dto->request->string('email_verified_at') ?? null,
            'is_verified' => $dto->request->boolean('is_verified') ?? false,
            'type' => $dto->request->string('type'),
            'country_id' => $dto->request->integer('country_id'),
            'state_id' => $dto->request->integer('state_id'),
            'default_currency' => $dto->currencyCode,
            'password' => bcrypt($dto->request->input('password')),
            'signed_up_from' => $dto->request->string('signed_up_from'),
            'status' => $dto->request->enum('status', UserStatus::class) ?? UserStatus::PENDING,
        ]);
    }
}
