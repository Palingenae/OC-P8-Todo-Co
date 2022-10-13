<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\HttpFoundation\Request;

class LoginTest extends AbstractTest
{
    use RefreshDatabaseTrait;

    public function testLogInFormUser(): void
    {
        $this->client->followRedirects();
        $urlGenerator = $this->client->getContainer()->get('router.default');
        
        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('login')
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('input#username');
    }

    public function testLogInUser(): void
    {
        $this->client->followRedirects();
        $urlGenerator = $this->client->getContainer()->get('router.default');
        
        $crawler = $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('login')
        );

        $form = $crawler->selectButton("Se connecter")->form();
        $form['_username'] = 'user';
        $form['_password'] = 'userPassword';

        $this->client->submit($form);

        $this->assertSelectorTextContains('a.btn.btn-danger', 'Se déconnecter');
    }
}