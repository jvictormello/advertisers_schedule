<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function listAllProducts(): JsonResponse
    {
        return response()->json(Product::all());
    }
}
