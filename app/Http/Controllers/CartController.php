<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function __invoke()
    {
        try {
            return response()->json(Product::all(), 200);
        } catch(Exception $e) {
            return response()->json('Unexpected error, try later!');
        }
    }
}
