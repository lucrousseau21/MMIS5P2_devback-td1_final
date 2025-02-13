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
    public function __invoke(Product $product)
    {
        return Inertia::render('Product', [
            'product' => $product,
            'auth' => [
                'user' => request()->user()
            ]
        ]);
    }
}
