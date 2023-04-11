<?php

namespace Tests;

use App\Models\Advertiser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createAdvertisers($args = []) {
        return Advertiser::factory()->create($args);
    }
}
