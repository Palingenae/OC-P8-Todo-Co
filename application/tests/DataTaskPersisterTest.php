<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\HttpFoundation\Request;

class DataTaskPersisterTest extends AbstractTest
{

    use RefreshDatabaseTrait;

    public function testLogInFormUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $client->clickLink('Se connecter');

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

    // public function testPersistCreateTask(): void
    // {
    //     $client = static::createClient();

    //     $client->request('GET', '/');
    //     $client->clickLink('Créer une nouvelle tâche');

    //     $this->assertResponseIsSuccessful();

    //     $client->waitForVisibility('[name="task"]');
    //     $this->assertSelectorExists('[name="task"]');
        
    // }

    // public function testPersistUpdateTask(): void
    // {
    //    // TODO : utiliser un crawler
    // }

    // public function testPersistDeleteTask(): void
    // {

    // }
}