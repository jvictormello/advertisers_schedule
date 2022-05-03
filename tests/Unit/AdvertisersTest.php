<?php

namespace Tests\Unit;

use App\Http\Controllers\AdvertisersController;
use App\Models\Advertisers;
use App\Services\Contracts\AdvertisersServiceContract;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Http\JsonResponse;

class AdvertisersTest extends TestCase
{
    public function testAdvertisersResponse()
    {
        $advertisersCollection = Advertisers::factory()->count(3)->make();
        $advertisersServiceMock = $this->createMock(AdvertisersServiceContract::class);
        $advertisersServiceMock->method('search')->willReturn($advertisersCollection);
        $advertisersController = new AdvertisersController($advertisersServiceMock);

        $this->assertEquals((new JsonResponse($advertisersCollection))->getData(), $advertisersController->list(new Request())->getData());
    }
}
