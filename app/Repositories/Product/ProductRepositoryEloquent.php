<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\ProductMethod;
use App\Repositories\Product\ProductRepositoryContract;

class ProductRepositoryEloquent implements ProductRepositoryContract
{

    protected $product;
    const MINIMAL_STOCK = 1;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAll()
    {
        return $this->product->paginate();
    }

    public function getWithStock()
    {
        return $this->product->where('quantity', '>=', self::MINIMAL_STOCK)->get();
    }

    public function getById(int $id)
    {
        return $this->product->whereId($id)->first();
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->product->whereId($id)->update($data);
    }

    public function delete(int $id)
    {
        $this->product->destroy($id);
    }
}
