<?php

namespace App\Tests;

class RoutesTest extends AbstractTest
{
    public function testDisplayHomepage()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testDisplayLoginPage()
    {
        $client = static::createClient();

        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLoggedUserPage()
    {
        $client = static::createClientWithUserCredentials();

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testTaskListLoggedUserPage()
    {
        $client = static::createClientWithUserCredentials();

        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
    }

    public function testCreateTaskLoggedUserPage()
    {
        $client = static::createClientWithUserCredentials();

        $client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
    }

    public function testUserListLoggedAdminPage() 
    {
        $client = static::createClientWithAdminCredentials();

        $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserLoggedAdminPage() 
    {
        $client = static::createClientWithAdminCredentials();

        $client->request('GET', '/users/create');
        $this->assertResponseIsSuccessful();
    }
}