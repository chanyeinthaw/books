<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\MockedDisk;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MockedDisk;

    protected function setUp(): void {
        parent::setUp();

        $this->mockDisk();
    }
}
