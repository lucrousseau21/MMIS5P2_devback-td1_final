<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {   
        $categories = Category::all();
        return Inertia::render('Categories', ['categories' => $categories]);
    }
    
    public function show($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $products = $category->products;

    return inertia('CategoryDetails', [
        'category' => $category,
        'products' => $products,
    ]);
}
}
