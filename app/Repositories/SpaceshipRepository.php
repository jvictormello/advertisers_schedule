<?php

namespace App\Repositories;

use App\Models\Spaceship;

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
        return $this->spaceship->get();
    }

    /**
     * Save Spaceship
     *
     * @param $data
     * @return Spaceship
     */
    public function save($data)
    {
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
        return $this->spaceship->findOrFail($id);
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
