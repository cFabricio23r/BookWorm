<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $rootDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rootDir = __DIR__;
    }
}
