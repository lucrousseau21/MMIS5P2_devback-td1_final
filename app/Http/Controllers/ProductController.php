<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        return Inertia::render('Products', ['products' => $products]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Product', [
            'product' => $product
        ]);
    }
}
