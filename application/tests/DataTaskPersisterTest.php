<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\Panther\Client;

class DataTaskPersisterTest extends AbstractTest
{

    use RefreshDatabaseTrait;

    public function testLogInUser(): Client
    {
        $client = Client::createChromeClient();
        $client->request('GET', '/');

        $client->clickLink('Se connecter');

        $this->assertResponseIsSuccessful();

        $client->waitForVisibility('input#username');
        
        $this->assertSelectorExists('input#username');

        return $client;
    }

    public function testPersistCreateTask(): void
    {
        $client = $this->testLogInUser();

        $client->request('GET', '/');
        $client->clickLink('Créer une nouvelle tâche');

        $this->assertResponseIsSuccessful();

        $client->waitForVisibility('[name="task"]');
        $this->assertSelectorExists('[name="task"]');
        
    }

    // public function testPersistUpdateTask(): void
    // {
    //    // TODO : utiliser un crawler
    // }

    // public function testPersistDeleteTask(): void
    // {

    // }
}