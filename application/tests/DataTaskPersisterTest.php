<?php

namespace App\Tests;

use App\Repository\TaskRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\HttpFoundation\Request;

class DataTaskPersisterTest extends AbstractTest
{

    use RefreshDatabaseTrait;

    public function testPersistCreateTask(): void
    {
        $this->client->followRedirects();
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $urlGenerator->generate('login');

        $crawler = $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('login')
        );

        $form = $crawler->selectButton("Se connecter")->form();
        $form['_username'] = 'user';
        $form['_password'] = 'userPassword';

        $this->client->submit($form);

        $this->assertSelectorExists('a.btn.btn-success');

        $crawler = $this->client->clickLink("Créer une nouvelle tâche");

        $taskForm = $crawler->selectButton("Ajouter")->form();
        $taskForm['task[title]'] = 'assertedTask';
        $taskForm['task[content]'] = 'assertedTaskContentForTesting';
        
        $this->client->submit($taskForm);

        $this->assertResponseIsSuccessful();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $assertedTask = $taskRepository->findOneByTitle('assertedTask');

        $this->assertSame('assertedTask', $assertedTask->getTitle());

    }

    // public function testPersistUpdateTask(): void
    // {
    //    // TODO : utiliser un crawler
    // }

    // public function testPersistDeleteTask(): void
    // {

    // }
}