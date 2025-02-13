<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowAllProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $products = Product::all();
        $products = $products->map(function ($product) {
            $product->price = $product->price / 100;
            return $product;
        });
        return Inertia::render('Products', ['products' => $products]);
    }
}
