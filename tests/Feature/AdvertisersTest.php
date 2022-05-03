<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdvertisersTest extends TestCase
{
    public function testApiAdvertisersUnauthorizedAccess()
    {
        $response = $this->get('/api/advertisers');
        $response->assertStatus(401);
    }

    public function testGenericAccess()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
