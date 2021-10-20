<?php

namespace App\Repositories;

use App\Models\Spaceship;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Log;

class SpaceshipRepository
{
    /**
     * @var Spaceship
     */
    protected $spaceship;

    /**
     * SpaceshipRepository constructor.
     *
     * @param Spaceship $spaceship
     */
    public function __construct(Spaceship $spaceship)
    {
        $this->spaceship = $spaceship;
    }

    /**
     * Get all spaceships.
     *
     * @return Spaceship $spaceship
     */
    public function getAll()
    {
        if (Cache::has('spaceships')) {
            $spaceships = json_decode(Cache::get('spaceships'));
            Log::info('Cache');
        } else {
            $spaceships = $this->spaceship->get();
            
            Cache::put('spaceships', json_encode($spaceships), now()->addMinutes(60));
            Log::info('Sem Cache');
        }

        return $spaceships;
    }

    /**
     * Save Spaceship
     *
     * @param $data
     * @return Spaceship
     */
    public function save($data)
    {
        Cache::forget('spaceships');

        return $this->spaceship->create($data);
    }
    
    /**
     * Get spaceship by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $cacheKey = 'spaceships:' . $id;

        if (Cache::has($cacheKey)) {
            $spaceship = collect(json_decode(Cache::get($cacheKey), true));
            Log::info('Cache');
        } else {
            $spaceship = $this->spaceship->findOrFail($id);

            $response = Http::get('https://api.thecatapi.com/v1/breeds/search', [
                'q' => $spaceship->name
            ])->object();

            $spaceship->info_from_api = $response;

            Cache::put($cacheKey, json_encode($spaceship), now()->addMinutes(60));
            Log::info('Sem Cache');
        }
        
        return $spaceship;
    }

    /**
     * Update Spaceship
     *
     * @param $data
     * @return Spaceship
     */
    public function update($data, $id)
    {
        $spaceship = $this->getSpaceship($id);

        if (is_null($spaceship)) {
            return ['error' => ['Spaceship not found.', null, 400]];
        }

        $spaceship->name = $data['name'];
        $spaceship->description = $data['description'];

        if (isset($data['capacity'])) {
            $spaceship->capacity = $data['capacity'];
        }

        $spaceship->update();

        Cache::forget('spaceships');

        return $spaceship;
    }

    /**
     * Update Spaceship
     *
     * @param $data
     * @return Spaceship
     */
    public function delete($id)
    {
        $spaceship = $this->getSpaceship($id);

        if (is_null($spaceship)) {
            return ['error' => ['Spaceship not found.', null, 400]];
        }

        $spaceship->delete();

        Cache::forget('spaceships');

        return true;
    }

    private function getSpaceship($id)
    {
        if (!is_numeric($id)) {
            return null;
        }

        $spaceship = $this->spaceship->find($id);

        if (empty($spaceship)) {
            return null;
        }

        return $spaceship;
    }
}
