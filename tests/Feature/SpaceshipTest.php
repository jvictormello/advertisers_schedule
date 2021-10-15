<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Spaceship;
use App\Repositories\SpaceshipRepository;

class SpaceshipTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function save_startship()
    {
        $spaceship = $this->createSpaceship();
      
        $this->assertInstanceOf(Spaceship::class, $spaceship['newData']);
        $this->assertEquals($spaceship['oldData']['name'], $spaceship['newData']['name']);
        $this->assertEquals($spaceship['oldData']['description'], $spaceship['newData']['description']);
        $this->assertEquals($spaceship['oldData']['capacity'], $spaceship['newData']['capacity']);
    }

    /** @test */
    public function update_startship()
    {
        $spaceship = $this->createSpaceship();

        $newData = [
            'name'        => $this->faker->name,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'capacity'    => $this->faker->randomDigit
        ];

        $spaceshipRepo = new SpaceshipRepository(new Spaceship);
        $updatedSpaceship = $spaceshipRepo->update($newData, $spaceship['newData']['id']);
      
        $this->assertInstanceOf(Spaceship::class, $updatedSpaceship);
        $this->assertEquals($newData['name'], $updatedSpaceship->name);
        $this->assertEquals($newData['description'], $updatedSpaceship->description);
        $this->assertEquals($newData['capacity'], $updatedSpaceship->capacity);
    }

    /** @test */
    public function delete_startship()
    {
        $spaceship = $this->createSpaceship();

        $spaceshipRepo = new SpaceshipRepository(new Spaceship);
        $result = $spaceshipRepo->delete($spaceship['newData']['id']);
      
        $this->assertTrue($result);
    }

    /** @test */
    public function show_startship()
    {
        $spaceship = $this->createSpaceship();

        $spaceshipRepo = new SpaceshipRepository(new Spaceship);
        $result = $spaceshipRepo->getById($spaceship['newData']['id']);
      
        $this->assertInstanceOf(Spaceship::class, $result);
        $this->assertEquals($spaceship['oldData']['name'], $result->name);
        $this->assertEquals($spaceship['oldData']['description'], $result->description);
        $this->assertEquals($spaceship['oldData']['capacity'], $result->capacity);
    }

    /** @test */
    public function all_startship()
    {
        $spaceship = $this->createSpaceship();

        $spaceshipRepo = new SpaceshipRepository(new Spaceship);
        $result = $spaceshipRepo->getAll();

        $this->assertTrue($result->contains('id', $spaceship['newData']['id']));
    }

    private function createSpaceship()
    {
        $data = [
            'name'        => $this->faker->name,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'capacity'    => $this->faker->randomDigit
        ];
      
        $spaceshipRepo = new SpaceshipRepository(new Spaceship);
        $spaceship = $spaceshipRepo->save($data);

        return [
            'oldData' => $data,
            'newData' => $spaceship
        ];
    }
}
