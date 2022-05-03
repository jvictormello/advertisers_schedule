<?php

namespace App\Repositories;

use App\Exceptions\QueryErrorException;
use Illuminate\Support\Collection;

class BaseRepository
{
    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function search(array $queryArray): Collection
    {
        try {
            $query = $this->model->query();
            foreach ($queryArray as $field => $value) {
                $query->where($field, 'like', sprintf('%%%s%%', $value));
            }
            return $query->get();
        } catch(\Exception $e) {
            throw new QueryErrorException($e);
        }
    }
}
