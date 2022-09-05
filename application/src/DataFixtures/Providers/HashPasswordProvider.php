<?php

namespace App\DataFixtures\Providers;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordProvider 
{
    /**
     * @var UserPasswordHasherInterface $hasher
     */
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function hashPassword (string $plainPassword): string
    {
        return $this->hasher->hashPassword(
            new User(), $plainPassword
        );
    }

}