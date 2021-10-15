<?php

namespace App\Services;

use App\Repositories\SpaceshipRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Exception;

class SpaceshipService
{
    /**
     * @var $spaceshipRepository
     */
    protected $spaceshipRepository;

    /**
     * SpaceshipService constructor.
     *
     * @param SpaceshipRepository $spaceshipRepository
     */
    public function __construct(SpaceshipRepository $spaceshipRepository)
    {
        $this->spaceshipRepository = $spaceshipRepository;
    }
    
    /**
     * Get all spaceship.
     *
     * @return String
     */
    public function getAll()
    {
        try {
            $spaceships = $this->spaceshipRepository->getAll();
        } catch (Exception $e) {
            return ['error' => ['Server failed.', null, 500]];
        }

        return $spaceships;
    }
    
    /**
     * Save spaceship data.
     *
     * @param array $data
     * @return String
     */
    public function save($data)
    {
        DB::beginTransaction();

        try {
            $spaceship = $this->spaceshipRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            return ['error' => ['Server failed.', null, 500]];
        }

        DB::commit();

        return $spaceship;
    }
    
    /**
     * Get spaceship by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        try {
            $spaceship = $this->spaceshipRepository->getById($id);
        } catch (Exception $e) {
            return ['error' => ['Server failed.', null, 500]];
        }

        return $spaceship;
    }

    /**
     * Update spaceship data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return array
     */
    public function update($data, $id)
    {
        DB::beginTransaction();

        try {
            $spaceship = $this->spaceshipRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            return ['error' => ['Server failed.', null, 500]];
        }

        DB::commit();

        return $spaceship;
    }

    /**
     * Delete spaceship by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($id)
    {
        try {
            $spaceship = $this->spaceshipRepository->delete($id);
        } catch (Exception $e) {
            return false;
        }

        return $spaceship;
    }
}
