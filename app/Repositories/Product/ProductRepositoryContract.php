<?php

namespace App\Repositories\Product;

interface ProductRepositoryContract 
{
    public function getAll();
    public function getWithStock();
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
 
}