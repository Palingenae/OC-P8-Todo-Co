<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class DataTaskPersisterTest extends AbstractTest
{

    use RefreshDatabaseTrait;

    public function testPersistCreateTask(): void
    {
        $client = static::createClientWithUserCredentials();

        
    }

    // public function testPersistUpdateTask(): void
    // {
    //    // TODO : utiliser un crawler
    // }

    // public function testPersistDeleteTask(): void
    // {

    // }
}