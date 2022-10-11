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

    protected function createClientWithAdminCredentials(): KernelBrowser
    {
        $client = static::createClient();
        $adminRepository = static::getContainer()->get(UserRepository::class);

        $testAdmin = $adminRepository->findOneByEmail('administrator@todoco.fr');
        $client->loginUser($testAdmin);

        return $client;
    }

    protected function createClientWithUserCredentials(): KernelBrowser
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('user@todoco.fr');
        $client->loginUser($testUser);

        return $client;
    }
}