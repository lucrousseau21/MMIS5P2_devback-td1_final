<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowOneProduct extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $productId = $request->route('id');
        $product = Product::find($productId);

        return Inertia::render('Product', ['product' => $product]);
    }
}
