<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractTest extends KernelTestCase
{

    protected function setUp(): void
    {
        self::createKernel();
    }
}