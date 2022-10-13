<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTest extends WebTestCase
{
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function createClientWithAdminCredentials(): void
    {
        $adminRepository = static::getContainer()->get(UserRepository::class);

        $testAdmin = $adminRepository->findOneByEmail('administrator@todoco.fr');
        $this->client->loginUser($testAdmin);
    }

    protected function createClientWithUserCredentials(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('user@todoco.fr');
        $this->client->loginUser($testUser);
    }
}