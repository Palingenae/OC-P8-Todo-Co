<?php

namespace App\Tests;

class RoutesTest extends AbstractTest
{
    public function testDisplayHomepage()
    {
        $this->client->followRedirects();

        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testDisplayLoginPage()
    {
        $this->client->followRedirects();

        $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLoggedUserPage()
    {
        static::createClientWithUserCredentials();

        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testTaskListLoggedUserPage()
    {
        static::createClientWithUserCredentials();

        $this->client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
    }

    public function testCreateTaskLoggedUserPage()
    {
        static::createClientWithUserCredentials();

        $this->client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
    }

    public function testUserListLoggedAdminPage() 
    {
        static::createClientWithAdminCredentials();

        $this->client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserLoggedAdminPage() 
    {
        static::createClientWithAdminCredentials();

        $this->client->request('GET', '/users/create');
        $this->assertResponseIsSuccessful();
    }
}