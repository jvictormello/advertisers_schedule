<?php

namespace Tests\Feature;

use App\Http\Controllers\AdvertisersController;
use App\Models\Advertisers;
use App\Models\Availabilities;
use App\Services\AdvertisersService;
use App\Services\AvailabilitiesService;
use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use App\Repositories\AvailabilitiesRepository;
use App\Repositories\AdvertisersRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdvertisersTest extends TestCase
{
    use RefreshDatabase;

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

    public function testAvailabilitiesList()
    {
        Advertisers::factory(10)->create();
        $availabilities = Availabilities::factory(1)->create();

        $availabilitiesService = new AvailabilitiesService(new AvailabilitiesRepository(new Availabilities()));
        $advertisersService = new AdvertisersService(new AdvertisersRepository(new Advertisers()));
        
        $advertisersController = new AdvertisersController(
            $advertisersService,
            $availabilitiesService
        );

        $expectedResponse = (new JsonResponse($availabilitiesService->searchByAdvertiserId($availabilities->first()->advertiser_id)))->getData();

        $realResponse = $advertisersController->listAvailabilities($availabilities->first()->advertiser_id)->getData();

        $this->assertEquals(
            $expectedResponse,
            $realResponse
        );
        $this->assertNotNull($realResponse->advertiser);
        $this->assertNotNull($realResponse->availabilities);
        
    }
}
